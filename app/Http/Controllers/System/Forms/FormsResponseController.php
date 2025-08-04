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

    public function index($uuid)
    {
        $response = FormsResponse::find($uuid);
        $form = $this->formRepository->getFormById($response->forms_id);
        $user = auth()->user();

        $steps = [
            "1" => isset($response->activitys) && count($response->activitys) > 0,
            "2" => isset($response->qtd_internal_audience) && isset($response->qtd_external_audience),
            "3" => isset($response->advances_extensionist_action),
            "4" => isset($response->internal_partners) && count($response->internal_partners) > 0,
            "5" => isset($response->external_partners) && count($response->external_partners) > 0,
            "6" => isset($response->extension_actions) && count($response->extension_actions) > 0,
            "7" => isset($response->social_technology_development),
            "8" => isset($response->social_medias) && count($response->social_medias) > 0,
            "9" => isset($response->images) && count($response->images) > 0,
            "10" => isset($response->instrument_avaliation),
        ];
        $this->data['form'] = $form;
        $this->data['response'] = $response;
        $this->data['steps'] = $steps;
        $this->data['progress'] = collect($steps)->filter()->count();
        // dd($this->data['progress']);
        return view('pages.response.dash', $this->data);



        // $this->data['base_projects'] = Projects::all();
        // $this->data['base_courses'] = Courses::all();

        // if ($this->data['form']) {
        //     $response = FormsResponse::where(['user_id' => $user->id, 'forms_id' => $this->data['form']->id])->with(['activitys', 'internal_partners', 'internal_partners.title_action_partner', 'external_partners', 'extension_actions', 'social_medias', 'images'])->first();
        //     $this->data['response'] = $response;

        //     if (!$response) {
        //         session()->forget('step');
        //     }
        // } else {
        //     $response = json_encode(['was_finished' => 0]);
        //     $this->data['response'] = json_decode($response);
        // }
        // $steps = [
        //     "1" => true,
        //     "2" => isset($response->coordinator_name) && isset($response->coordinator_profile) && isset($response->coordinator_course) && isset($response->coordinator_siape),
        //     "3" => isset($response->activitys),
        //     "4" => isset($response->qtd_internal_audience) && isset($response->qtd_external_audience),
        //     "5" => isset($response->advances_extensionist_action),
        //     "6" => isset($response->internal_partners) && count($response->internal_partners) > 0,
        //     "7" => isset($response->external_partners) && count($response->external_partners) > 0,
        //     "8" => isset($response->extension_actions) && count($response->extension_actions) > 0,
        //     "9" => isset($response->social_technology_development),
        //     "10" => isset($response->social_medias) && count($response->social_medias) > 0,
        //     "11" => isset($response->images) && count($response->images) > 0,
        //     "12" => isset($response->instrument_avaliation),
        // ];

        // $step = session('step');

        // if (!$step) {
        //     $step_actual = 0;

        //     if ($steps[3]) {
        //         $steps[4] = true;
        //     }
        //     foreach ($steps as $key => $step) {
        //         if ($step) {
        //             $step_actual = $key;
        //         }
        //     }
        //     session()->put('step', $step_actual);
        // }

        // $this->data['steps'] = $steps;

        // $finished = 0;

        // foreach ($steps as $key => $step_f) {
        //     if ($step_f) {
        //         $finished++;
        //     }
        // }

        // if ($finished == 12) {
        //     $this->data['finished'] = true;
        // } else {
        //     $this->data['finished'] = false;
        // }

        // return view('pages.forms.index', $this->data);
    }

    public function edit($id)
    {
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

    public function update(UpdateRequest $request, $id)
    {
        return $this->responseService->updateResponse($request, $id);
    }

    public function persist(StoreRequest $request, $uuid)
    {
        return $this->responseService->persistResponse($request, $uuid);
    }

    public function advance($uuid, $next)
    {
        return to_route('response.session', [$uuid, $next]);
    }

    public function return($uuid, $back)
    {
        return to_route('response.session', [$uuid, $back]);
    }

    public function finish()
    {
        return $this->responseService->finishResponse();
    }

    public function start($uuid)
    {
        $response = FormsResponse::find($uuid);
        $form = $this->formRepository->getFormById($response->forms_id);
        $user = auth()->user();

        if ($form->status == 1) {
            $steps = [
                "1" => isset($response->activitys) && count($response->activitys) > 0,
                "2" => isset($response->qtd_internal_audience) && isset($response->qtd_external_audience),
                "3" => isset($response->advances_extensionist_action),
                "4" => isset($response->internal_partners) && count($response->internal_partners) > 0,
                "5" => isset($response->external_partners) && count($response->external_partners) > 0,
                "6" => isset($response->extension_actions) && count($response->extension_actions) > 0,
                "7" => isset($response->social_technology_development),
                "8" => isset($response->social_medias) && count($response->social_medias) > 0,
                "9" => isset($response->images) && count($response->images) > 0,
                "10" => isset($response->instrument_avaliation)
            ];

            foreach ($steps as $key => $step) {
                if (!$step) {
                    return to_route('response.session', [$response->id, $key]);
                }
            }
            return to_route('response.session', [$response->id, 1]);
        } else {
            return redirect()->back()->with('toats_error', 'O formulário não está mais disponível para preenchimento');
        }
    }

    public function session($uuid, $session)
    {
        $response = FormsResponse::find($uuid);
        $form = $this->formRepository->getFormById($response->forms_id);

        if ($form->status == 0) {
            return redirect()->back()->with('toast_error', 'O formulário não está mais disponível para preenchimento');
        }

        $steps = [
            "1" => isset($response->activitys) && count($response->activitys) > 0,
            "2" => isset($response->qtd_internal_audience) && isset($response->qtd_external_audience),
            "3" => isset($response->advances_extensionist_action),
            "4" => isset($response->internal_partners) && count($response->internal_partners) > 0,
            "5" => isset($response->external_partners) && count($response->external_partners) > 0,
            "6" => isset($response->extension_actions) && count($response->extension_actions) > 0,
            "7" => isset($response->social_technology_development),
            "8" => isset($response->social_medias) && count($response->social_medias) > 0,
            "9" => isset($response->images) && count($response->images) > 0,
            "10" => isset($response->instrument_avaliation),
        ];
        $this->data['form'] = $form;
        $this->data['response'] = $response;
        $this->data['steps'] = $steps;
        $this->data['base_projects'] = Projects::where('status', 1)->get();

        if ($session == 1) {
            return view('pages.response.steps.one', $this->data);
        } else if ($session == 2) {
            return view('pages.response.steps.two', $this->data);
        } else if ($session == 3) {
            return view('pages.response.steps.three', $this->data);
        } else if ($session == 4) {
            return view('pages.response.steps.four', $this->data);
        } else if ($session == 5) {
            return view('pages.response.steps.five', $this->data);
        } else if ($session == 6) {
            return view('pages.response.steps.six', $this->data);
        } else if ($session == 7) {
            return view('pages.response.steps.seven', $this->data);
        } else if ($session == 8) {
            return view('pages.response.steps.eight', $this->data);
        } else if ($session == 9) {
            return view('pages.response.steps.nine', $this->data);
        } else if ($session == 10) {
            return view('pages.response.steps.ten', $this->data);
        } else {
            return redirect()->back()->with('toast_error', 'Sessão não encontrda!');
        }
    }
}
