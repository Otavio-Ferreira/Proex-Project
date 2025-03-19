<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\StoreRequest;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Repositories\Forms\Form\FormRepository;
use App\Services\Forms\FormService;
use Illuminate\Http\Request;

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

    public function create(Request $request)
    {
        $this->data['forms'] = $this->formRepository->getAllForm($request);
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

            $responses = FormsResponse::where(['forms_id' => $id, 'was_finished' => $key])->with(['activitys', 'internal_partners', 'internal_partners.title_action_partner', 'external_partners', 'extension_actions', 'social_medias', 'images', 'user', 'action'])->get();

            foreach ($responses as $key2 => $response) {
                $finished = 0;
                $steps = [
                    "1" => isset($response->title_action) && isset($response->action_modality) && isset($response->type_action),
                    "2" => isset($response->coordinator_name) && isset($response->coordinator_profile) && isset($response->coordinator_course) && isset($response->coordinator_siape),
                    "3" => isset($response->activitys) && count($response->activitys) > 0,
                    "4" => isset($response->qtd_internal_audience) && isset($response->qtd_external_audience),
                    "5" => isset($response->advances_extensionist_action),
                    "6" => isset($response->internal_partners) && count($response->internal_partners) > 0,
                    "7" => isset($response->external_partners) && count($response->external_partners) > 0,
                    "8" => isset($response->extension_actions) && count($response->extension_actions) > 0,
                    "9" => isset($response->social_technology_development),
                    "10" => isset($response->social_medias) && count($response->social_medias) > 0,
                    "11" => isset($response->images) && count($response->images) >= 3,
                    "12" => isset($response->instrument_avaliation),
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

        return view('pages.forms.show', $this->data);
    }

    public function store(StoreRequest $request)
    {
        return $this->formService->storeResponse($request);
    }

    public function update(Request $request, $id)
    {
        return $this->formService->updateResponse($request, $id);
    }
}
