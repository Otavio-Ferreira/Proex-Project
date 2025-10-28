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
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

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

    public function index(Request $request)
    {
        $this->data['projects'] = $this->projetcsRepository->getAllPaginate($request);

        return view('pages.projects.index', $this->data);
    }

    public function create()
    {
        $this->data['types'] = Parameters::where(['function' => 'TIPO', 'status' => 1])->orderBy('value', 'asc')->get();
        $this->data['modalities'] = Parameters::where(['function' => 'MODALIDADE', 'status' => 1])->orderBy('value', 'asc')->get();
        $this->data['thematic_area'] = Parameters::where(['function' => 'ÁREA TEMÁTICA', 'status' => 1])->orderBy('value', 'asc')->get();
        $this->data['courses'] = Courses::orderBy('name', 'asc')->get();
        $this->data['teachers'] = User::get();
        $this->data['last'] = Projects::orderBy('id_atividade', 'desc')->first();

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

        $history = $grouped->values()->sortByDesc('first_date')->toArray();

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

        $headerLine = fgets($handle);
        if ($headerLine === false) {
            fclose($handle);
            return redirect()->back()->with("toast_error", "Arquivo CSV vazio ou inválido.");
        }

        $commaCount = substr_count($headerLine, ',');
        $semicolonCount = substr_count($headerLine, ';');
        $delimiter = $semicolonCount > $commaCount ? ';' : ',';

        DB::beginTransaction();
        try {
            $projectsToInsert = [];
            $idSubmit = (string) Str::uuid();
            $now = now();

            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                // Força UTF-8 e aplica trim() em todos os campos
                $row = array_map(function ($field) {
                    return trim(mb_convert_encoding($field, 'UTF-8', 'auto'));
                }, $row);

                // Preenche com null se faltar coluna
                $row = array_pad($row, 13, null);

                // Normaliza email
                $email = strtolower($row[5] ?? '');

                // Curso
                $course = null;
                if (!empty($row[6])) {
                    $course = Courses::firstOrCreate(['name' => $row[6]]);
                }

                // Usuário
                $user = null;
                if (!empty($row[5])) {
                    $user = User::where('email', $email)->first();
                    if (!$user) {
                        $user = $this->usersRepository->setForce($row[3], $row[4], $email, $course->id);
                        $user->assignRole("Visitante");
                    }
                }

                // Parâmetros
                $type = !empty($row[10])
                    ? Parameters::firstOrCreate(
                        ['function' => 'TIPO', 'value' => strtoupper($row[10])],
                        ['value' => $row[10]]
                    )
                    : null;

                $thematic_area = !empty($row[11])
                    ? Parameters::firstOrCreate(
                        ['function' => 'ÁREA TEMÁTICA', 'value' => strtoupper($row[11])],
                        ['value' => $row[11]]
                    )
                    : null;

                $modality = !empty($row[12])
                    ? Parameters::firstOrCreate(
                        ['function' => 'MODALIDADE', 'value' => strtoupper($row[12])],
                        ['value' => $row[12]]
                    )
                    : null;

                // Datas seguras
                $startDate = null;
                $endDate = null;

                if (!empty($row[7])) {
                    try {
                        $startDate = Carbon::createFromFormat('d/m/Y', $row[7])->format('Y-m-d');
                    } catch (\Exception $e) {
                        try {
                            $startDate = Carbon::createFromFormat('d/m/Y H:i:s', $row[7])->format('Y-m-d');
                        } catch (\Exception $e) {
                            $startDate = null;
                        }
                    }
                }

                if (!empty($row[8])) {
                    try {
                        $endDate = Carbon::createFromFormat('d/m/Y', $row[8])->format('Y-m-d');
                    } catch (\Exception $e) {
                        try {
                            $endDate = Carbon::createFromFormat('d/m/Y H:i:s', $row[8])->format('Y-m-d');
                        } catch (\Exception $e) {
                            $endDate = null;
                        }
                    }
                }

                // Monta o projeto
                $projectData = [
                    'id_atividade'  => $row[0] ?? null,
                    'id_projeto'    => $row[1] ?? null,
                    'title'         => $row[2] ?? null,
                    'coordinator'   => $user->id ?? null,
                    'course'        => $course->id ?? null,
                    'start_date'    => $startDate,
                    'end_date'      => $endDate,
                    'year'          => $row[9] ?? null,
                    'type'          => $type->value ?? null,
                    'thematic_area' => $thematic_area->value ?? null,
                    'modality'      => $modality->value ?? null,
                    'type_submit'   => 'import',
                    'id_submit'     => $idSubmit,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                    'status'        => 1,
                ];

                // Campos usados para checar duplicados
                $checkData = [
                    'id_atividade'  => $row[0] ?? null,
                    'id_projeto'    => $row[1] ?? null,
                    'title'         => $row[2] ?? null,
                    'coordinator'   => $user->id ?? null,
                    'course'        => $course->id ?? null,
                    'start_date'    => $startDate,
                    'end_date'      => $endDate,
                    'year'          => $row[9] ?? null,
                    'type'          => $type->value ?? null,
                    'thematic_area' => $thematic_area->value ?? null,
                    'modality'      => $modality->value ?? null,
                    'status'        => 1,
                ];

                // Verifica se já existe (comparando todos os campos relevantes)
                $exists = DB::table('projects')->where($checkData)->exists();

                if (!$exists) {
                    $projectsToInsert[] = array_merge(['id' => Str::uuid()], $projectData);
                }
            }

            if (!empty($projectsToInsert)) {
                DB::table('projects')->insert($projectsToInsert);

                $user = auth()->user();
                $project = Projects::first();

                activity()->causedBy($user)->performedOn($project)->event('imported')->withProperties([
                    'attributes' => [
                        'message' => 'Uma importação em lote de ' . count($projectsToInsert) . ' projetos foi realizada.',
                    ]
                ])->log('imported');
            }

            DB::commit();
            fclose($handle);

            return redirect()->back()->with("toast_success", "Projetos importados com sucesso!");
        } catch (\Exception $e) {
            DB::rollBack();
            if ($handle) {
                fclose($handle);
            }
            return redirect()->back()->with("toast_error", "Erro na importação: " . $e->getMessage());
        }
    }

    public function edit($uuid)
    {
        $this->data['types'] = Parameters::where(['function' => 'TIPO', 'status' => 1])->orderBy('value', 'asc')->get();
        $this->data['modalities'] = Parameters::where(['function' => 'MODALIDADE', 'status' => 1])->orderBy('value', 'asc')->get();
        $this->data['thematic_area'] = Parameters::where(['function' => 'ÁREA TEMÁTICA', 'status' => 1])->orderBy('value', 'asc')->get();
        $this->data['courses'] = Courses::orderBy('name', 'asc')->get();
        $this->data['teachers'] = User::get();
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

    public function analysis(String $id, Request $request)
    {
        $this->data['projects'] = $this->projetcsRepository->getAllPaginate($request, $id);
        $this->data['last'] = Projects::orderBy('id_atividade', 'desc')->first();
        $this->data['types'] = Parameters::where(['function' => 'TIPO', 'status' => 1])->orderBy('value', 'asc')->get();
        $this->data['modalities'] = Parameters::where(['function' => 'MODALIDADE', 'status' => 1])->orderBy('value', 'asc')->get();
        $this->data['thematic_area'] = Parameters::where(['function' => 'ÁREA TEMÁTICA', 'status' => 1])->orderBy('value', 'asc')->get();
        $this->data['courses'] = Courses::orderBy('name', 'asc')->get();
        $this->data['teachers'] = User::orderBy('name', 'asc')->get();
        return view('pages.projects.analysis', $this->data);
    }

    public function destroy($uuid)
    {
        try {
            $project = Projects::find($uuid);
            $project->delete();
            return redirect()->back()->with('toast_success', 'Registro removido com sucesso.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', 'Registro não encontrado.');
        }
    }
}
