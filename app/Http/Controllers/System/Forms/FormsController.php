<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\StoreRequest;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Models\Parameters\Parameters;
use App\Models\Parameters\Projects;
use App\Models\User;
use App\Repositories\Forms\Form\FormRepository;
use App\Services\Forms\FormService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use Spatie\Permission\Models\Permission;

class FormsController extends Controller
{
    private $data = [];
    private $formService;
    private $formRepository;

    public function __construct(
        FormService $formService,
        FormRepository $formRepository
    ) {
        $this->formService = $formService;
        $this->formRepository = $formRepository;
    }

    public function index(Request $request)
    {
        $this->data['forms'] = $this->formRepository->getAllForm($request);
        $this->data['total_active_projects'] = Projects::where('status', 1)->count();
        $this->data['total_inative_projects'] = Projects::where('status', 0)->count();
        $this->data['modalities'] = Parameters::where(['function' => 'MODALIDADE', 'status' => 1])->get();
        $this->data['qtd_users'] = User::where('status', 1)->get()->filter(function ($user) {
            return $user->hasPermissionTo('responder_formulário');
        })->count();

        return view('pages.forms.index', $this->data);
    }

    public function create()
    {
        $this->data['modalities'] = Parameters::where(['function' => 'MODALIDADE', 'status' => 1])->get();
        return view('pages.forms.create', $this->data);
    }

    public function show($id)
    {
        $type_status = [
            0 => [
                "TITULO" => "Andamento",
                "COR" => "secondary",
                "ORDEM" => 0,
                "PROGRESS" => 0,
                "DATA" => [],
            ],
            1 => [
                "TITULO" => "Enviado",
                "COR" => "blue",
                "ORDEM" => 1,
                "PROGRESS" => 0,
                "DATA" => [],
            ],
            2 => [
                "TITULO" => "Revisão",
                "COR" => "red",
                "ORDEM" => 2,
                "PROGRESS" => 0,
                "DATA" => [],
            ],
            3 => [
                "TITULO" => "Corrigido",
                "COR" => "green",
                "ORDEM" => 3,
                "PROGRESS" => 0,
                "DATA" => [],
            ],
            4 => [
                "TITULO" => "Aprovados",
                "COR" => "dark",
                "ORDEM" => 4,
                "PROGRESS" => 0,
                "DATA" => [],
            ],
        ];
        $columns = [];

        foreach ($type_status as $key => $status) {
            $columns[$key]['TITULO'] = $status['TITULO'];
            $columns[$key]['COR'] = $status['COR'];
            $columns[$key]['DATA'] = [];

            $responses = FormsResponse::where(['forms_id' => $id, 'was_finished' => $key])->with(['activitys', 'internal_partners', 'internal_partners.title_action_partner', 'external_partners', 'extension_actions', 'social_medias', 'images', 'user'])->get();

            foreach ($responses as $key2 => $response) {
                $finished = 0;
                $steps = [
                    isset($response->title_action) && isset($response->action_modality) && isset($response->type_action),
                    isset($response->coordinator_name) && isset($response->coordinator_profile) && isset($response->coordinator_course) && isset($response->coordinator_siape),
                    isset($response->activitys) && count($response->activitys) > 0,
                    isset($response->qtd_internal_audience) && isset($response->qtd_external_audience),
                    isset($response->advances_extensionist_action),
                    // isset($response->internal_partners) && count($response->internal_partners) > 0,
                    // isset($response->external_partners) && count($response->external_partners) > 0,
                    isset($response->extension_actions) && count($response->extension_actions) > 0,
                    isset($response->social_technology_development),
                    isset($response->social_medias) && count($response->social_medias) > 0,
                    isset($response->images) && count($response->images) >= 3,
                    isset($response->instrument_avaliation),
                ];

                foreach ($steps as $step_f) {
                    if ($step_f) {
                        $finished++;
                    }
                }
                $columns[$key]['DATA'][$key2]['PROGRESS'] = $finished;
                $columns[$key]['DATA'][$key2]['RESPONSE'] = $response;
            }
        }

        ksort($columns);
        // dd($columns);
        $this->data['columns'] = $columns;
        $this->data['type'] = $type_status;
        $this->data['form'] = Forms::find($id);

        $dateRanges = [];

        foreach ($this->data['form']->responses as $response) {
            if ($project = $response->project) {
                if ($project->start_date && $project->end_date) {

                    $startYear = Carbon::parse($project->start_date)->year;
                    $endYear = Carbon::parse($project->end_date)->year;

                    $value = "{$startYear}-{$endYear}";
                    $label = "{$startYear} até {$endYear}";

                    $dateRanges[$value] = $label;
                }
            }
        }

        $this->data['dateRanges'] = $dateRanges;

        return view('pages.forms.show', $this->data);
    }

    public function reports($id)
    {
        $this->data['form'] = $this->formRepository->getFormById($id);
        return view('pages.forms.reports', $this->data);
    }

    public function store(StoreRequest $request)
    {
        return $this->formService->storeResponse($request);
    }

    public function update(StoreRequest $request, $id)
    {
        return $this->formService->updateResponse($request, $id);
    }

    public function makeAvailable(Request $request, $id)
    {

        try {
            $form = $this->formRepository->getFormById($id);

            foreach ($request->modalities as $modality) {
                $active_projects = Projects::where(['status' => 1, 'modality' => $modality])->get();
                foreach ($active_projects as $project) {
                    if ($project->coordinator) {
                        $response = FormsResponse::where(['project_id' => $project->id, 'forms_id' => $form->id])->first();
                        if (!$response) {
                            FormsResponse::create([
                                'forms_id' => $form->id,
                                'user_id' => $project->coordinator,
                                'project_id' => $project->id,
                            ]);
                        }
                    }
                }
            }
            return redirect()->back()->with('toast_success', 'Formulário disponibilizado com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', 'Erro ao disponibilizar formulário, tente novamente mais tarde!');
        }
    }
}
