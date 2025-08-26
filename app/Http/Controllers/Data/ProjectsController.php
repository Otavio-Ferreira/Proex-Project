<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projetcs\ImportRequest;
use App\Http\Requests\Projetcs\StoreRequest;
use App\Models\Parameters\Courses;
use App\Models\Parameters\Parameters;
use App\Models\Parameters\Projects;
use App\Models\User;
use App\Repositories\Projects\ProjectsRepository;
use App\Repositories\Settings\Users\UsersRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectsController extends Controller
{
    private $data = [];
    private $projetcsRepository;
    private $usersRepository;

    public function __construct(ProjectsRepository $projetcsRepository, UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->projetcsRepository = $projetcsRepository;
    }

    public function index()
    {

        $this->data['projects'] = $this->projetcsRepository->getAll();

        return view('pages.projects.index', $this->data);
    }

    public function create()
    {
        $this->data['courses'] = Courses::all();
        $this->data['teachers'] = User::role('Professor')->get();

        return view('pages.projects.create', $this->data);
    }

    public function import()
    {
        $this->data['projects'] = Projects::where('type_submit', 'import')->get();

        $projects = Projects::where('type_submit', 'import')->get();

        $grouped = $projects->groupBy('id_submit')->map(function ($items, $idSubmit) {
            $sorted = $items->sortBy('created_at');
            $first = $sorted->first()->created_at;
            $last  = $sorted->last()->created_at;

            $hasNull = $items->contains(function ($item) {
                foreach ($item->getAttributes() as $key => $value) {
                    if (!in_array($key, ['updated_at', 'deleted_at'])) {
                        if (is_null($value)) {
                            return true;
                        }
                    }
                }
                return false;
            });
            return [
                'id_submit'   => $idSubmit,
                'first_date'  => $first,
                'last_date'   => $last,
                'qtd'   => $items->count(),
                'msg'         => $hasNull ? 'Existe(m) campo(s) vazio(s)' : 'Todos os campos preenchidos'
            ];
        });

        $history = $grouped->values()->toArray();

        $this->data['projects'] = $history;

        return view('pages.projects.import', $this->data);
    }

    public function store(StoreRequest $request)
    {
        try {
            $this->projetcsRepository->create($request);
            return redirect()->back()->with("toast_success", "Projeto cadastrado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao cadastrar projeto. Por favor, tente novamente mais tarde.")->withInput();
        }
    }

    public function storeImport(ImportRequest $request)
    {

        $file = $request->file('csv');
        $handle = fopen($file->getRealPath(), "r");

        $headerLine = fgets($handle); // Lê a primeira linha (cabeçalho)
        if ($headerLine === false) {
            fclose($handle);
            return redirect()->back()->with("toast_error", "Arquivo CSV vazio ou inválido.");
        }

        $commaCount = substr_count($headerLine, ',');
        $semicolonCount = substr_count($headerLine, ';');

        // Define o delimitador com base no caractere mais frequente no cabeçalho
        $delimiter = $semicolonCount > $commaCount ? ';' : ',';

        DB::beginTransaction();

        try {
            // O cabeçalho já foi lido pela lógica de detecção, então o loop começa na primeira linha de dados.
            $projectsToInsert = [];
            $idSubmit = uniqid();
            $now = now();

            // 3. Loop para ler o arquivo e preparar os dados
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) { // Usa o delimitador detectado
                // Converte a codificação para UTF-8 para evitar problemas com caracteres especiais
                $row = array_map(function ($field) {
                    return mb_convert_encoding($field, 'UTF-8', 'auto');
                }, $row);

                $user = User::where('email', $row[5])->first();
                $email = trim($row[5] ?? '');
                $course = Courses::where('name', $row[6])->first();
                
                if (!$user && !empty($email)){
                    $user = $this->usersRepository->setForce($row[3], $row[4], $row[5], $course->id);
                }

                if (!$course) {
                    $course = Courses::create([
                        'name' => $row[6]
                    ]);
                }

                $type = Parameters::where(['function' => 'TIPO', 'value' => strtoupper($row[10])])->first();
                if (!$type) {
                    $type = Parameters::create([
                        'function' => 'TIPO',
                        'value' => $row[10]
                    ]);
                }

                $thematic_area = Parameters::where(['function' => 'ÁREA TEMÁTICA', 'value' => strtoupper($row[11])])->first();
                if (!$thematic_area) {
                    $thematic_area = Parameters::create([
                        'function' => 'ÁREA TEMÁTICA',
                        'value' => $row[11]
                    ]);
                }


                $modality = Parameters::where(['function' => 'MODALIDADE', 'value' => strtoupper($row[12])])->first();
                if (!$modality) {
                    $modality = Parameters::create([
                        'function' => 'MODALIDADE',
                        'value' => $row[12]
                    ]);
                }

                // Monta o array de dados para cada linha
                $data = [
                    'id' => Str::uuid(),
                    'id_atividade'  => $row[0] ?? null,
                    'id_projeto'    => $row[1] ?? null,
                    'title'         => $row[2] ?? null,

                    'coordinator'   => $user->id ?? null,
                    'course'        => $course->id ?? null,

                    'start_date'    => !empty($row[7]) ? Carbon::createFromFormat('d/m/Y', $row[7])->format('Y-m-d') : null,
                    'end_date'      => !empty($row[8]) ? Carbon::createFromFormat('d/m/Y', $row[8])->format('Y-m-d') : null,
                    'year'          => $row[9] ?? null,

                    'type'          =>  $type->value ?? null,
                    'thematic_area' => $thematic_area->value ?? null,
                    'modality'      => $modality->value ?? null,

                    'type_submit'   => 'import',
                    'id_submit'     => $idSubmit,
                    'created_at'    => now(),
                    'status'    => true,
                ];

                $projectsToInsert[] = $data;
            }

            // 4. Inserção em massa (Bulk Insert)
            if (!empty($projectsToInsert)) {
                DB::table('projects')->insert($projectsToInsert);
            }

            DB::commit();

            return redirect()->back()->with("toast_success", "Projetos importados com sucesso!");
        } catch (\Exception $e) {
            // 5. Tratamento de erro
            DB::rollBack();
            return redirect()->back()->with("toast_error", "Ocorreu um erro durante a importação. Verifique o formato do arquivo e dos dados. Nenhuma informação foi salva.");
        } finally {
            if ($handle) {
                fclose($handle);
            }
        }
    }


    public function edit($uuid)
    {
        $this->data['courses'] = Courses::all();
        $this->data['teachers'] = User::role('Professor')->get();
        $this->data['project'] = $this->projetcsRepository->getById($uuid);

        return view('pages.projects.edit', $this->data);
    }

    public function update(StoreRequest $request, $uuid)
    {
        try {
            $this->projetcsRepository->update($request, $uuid);
            return redirect()->back()->with("toast_success", "Projeto atualizado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao atualizar projeto. Por favor, tente novamente mais tarde.")->withInput();
        }
    }

    public function myProjects(Request $request)
    {
        $user = Auth::user();
        $this->data['projects'] = $this->projetcsRepository->getByUserId($user->id, $request);
        return view('pages.projects.my', $this->data);
    }
}
