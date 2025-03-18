<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormsResponse\StoreRequest;
use App\Http\Requests\FormsResponse\UpdateRequest;
use App\Models\Forms\Comments;
use Illuminate\Http\Request;
use App\Models\Forms\FormsResponse;
use App\Models\Parameters\Courses;
use App\Models\Parameters\Projects;
use App\Repositories\Forms\Form\FormRepository;
use App\Repositories\Forms\Response\ResponseRepository;
use App\Services\Forms\ResponseService;

class FormsResponseController extends Controller
{
    private $data = [];
    private $responseService;
    private $responseRepository;
    private $formRepository;

    public function __construct(
        ResponseService $responseService,
        ResponseRepository $responseRepository,
        FormRepository $formRepository
    ) {
        $this->responseService = $responseService;
        $this->responseRepository = $responseRepository;
        $this->formRepository = $formRepository;
    }

    public function index()
    {
        $user = auth()->user();
        $this->data['form'] = $this->formRepository->getActualForm();
        $this->data['base_projects'] = Projects::all();
        $this->data['base_courses'] = Courses::all();

        if ($this->data['form']) {
            $response = FormsResponse::where(['user_id' => $user->id, 'forms_id' => $this->data['form']->id])->with(['activitys', 'internal_partners', 'internal_partners.title_action_partner', 'external_partners', 'extension_actions', 'social_medias', 'images'])->first();
            $this->data['response'] = $response;

            if (!$response) {
                session()->forget('step');
            }
        } else {
            $response = json_encode(['was_finished' => 0]);
            $this->data['response'] = json_decode($response);
        }
        $steps = [
            "1" => true,
            "2" => isset($response->coordinator_name) && isset($response->coordinator_profile) && isset($response->coordinator_course) && isset($response->coordinator_siape),
            "3" => isset($response->activitys),
            "4" => isset($response->qtd_internal_audience) && isset($response->qtd_external_audience),
            "5" => isset($response->advances_extensionist_action),
            "6" => isset($response->internal_partners) && count($response->internal_partners) > 0,
            "7" => isset($response->external_partners) && count($response->external_partners) > 0,
            "8" => isset($response->extension_actions) && count($response->extension_actions) > 0,
            "9" => isset($response->social_technology_development),
            "10" => isset($response->social_medias) && count($response->social_medias) > 0,
            "11" => isset($response->images) && count($response->images) > 0,
            "12" => isset($response->instrument_avaliation),
        ];

        $step = session('step');

        if (!$step) {
            $step_actual = 0;

            if ($steps[3]) {
                $steps[4] = true;
            }
            foreach ($steps as $key => $step) {
                if ($step) {
                    $step_actual = $key;
                }
            }
            session()->put('step', $step_actual);
        }

        $this->data['steps'] = $steps;

        $finished = 0;

        foreach ($steps as $key => $step_f) {
            if ($step_f) {
                $finished++;
            }
        }

        if ($finished == 12) {
            $this->data['finished'] = true;
        } else {
            $this->data['finished'] = false;
        }

        return view('pages.forms.index', $this->data);
    }

    public function edit($id){
        $this->data['response'] = FormsResponse::where('id', $id)->with(['activitys', 'internal_partners', 'internal_partners.title_action_partner', 'external_partners', 'extension_actions', 'social_medias', 'images'])->first();

        $type_status = [
            0 => [
                "TITULO" => "Andamento",
                "COR" => "secondary",
                "ORDEM" => 0,
            ],
            1 => [
                "TITULO" => "Enviado",
                "COR" => "blue",
                "ORDEM" => 1,
            ],
            2 => [
                "TITULO" => "Revisão",
                "COR" => "red",
                "ORDEM" => 2,
            ],
            3 => [
                "TITULO" => "Corrigido",
                "COR" => "green",
                "ORDEM" => 3,
            ],
            4 => [
                "TITULO" => "Aprovados",
                "COR" => "dark",
                "ORDEM" => 4,
            ],
        ];
        
        $this->data['info'] = [
            "status" => $this->data['response']->was_finished,
            "color" => $type_status[$this->data['response']->was_finished]['COR'],
            "name" => $type_status[$this->data['response']->was_finished]['TITULO']
        ];

        $this->data['comment'] = Comments::where('form_response_id', $this->data['response']->id)->first();
        return view('pages.response.edit', $this->data);
    }

    public function update(UpdateRequest $request, $id){
        return $this->responseService->updateResponse($request, $id);
    }

    public function persist(StoreRequest $request)
    {
        return $this->responseService->persistResponse($request);
    }

    public function advance($actual_step)
    {
        session()->put('step', $actual_step + 1);
        return redirect()->back()->with('toast_success', 'Seção enviada com sucesso!');
    }

    public function return($actual_step)
    {
        session()->put('step', $actual_step - 1);
        return redirect()->back()->with('toast_success', 'Seção enviada com sucesso!');
    }

    public function finish()
    {
        return $this->responseService->finishResponse();
    }
}
