<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\StoreRequest;
use App\Models\Forms\Activitys;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Models\Parameters\Courses;
use App\Models\Parameters\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormsController extends Controller
{
    private $data = [];

    public function index()
    {
        $user = auth()->user();
        $this->data['form'] = Forms::where('status', '1')->first();
        $this->data['base_projects'] = Projects::all();
        $this->data['base_courses'] = Courses::all();

        if ($this->data['form']) {
            $response = FormsResponse::where(['user_id' => $user->id, 'forms_id' => $this->data['form']->id])->with(['activitys'])->first();
            $this->data['response'] = $response;
        }
        // dd($response);

        // isset($response->title_action) && isset($response->type_action) && isset($response->action_modality)
        // "3" => Activitys::where('response_forms_id', $response->id)->count() > 0,

        $steps = [
            "1" => true,
            "2" => isset($response->coordinator_name) && isset($response->coordinator_profile) && isset($response->coordinator_course) && isset($response->coordinator_siape),
            "3" => isset($response->activitys),
            "4" => isset($response->qtd_internal_audience) && isset($response->qtd_external_audience),
            "5" => isset($response->advances_extensionist_action),
            "6" => isset($response->social_technology_development),
            "7" => isset($response->instrument_avaliation),
            "8" => isset($response->internal_partners) && count($response->internal_partners) > 0,
            "9" => isset($response->external_partners) && count($response->external_partners) > 0,
            "10" => isset($response->social_media) && count($response->social_media) > 0,
            "11" => isset($response->images) && count($response->images) > 0,
        ];

        if(!$response){
            session()->forget('step'); 
        }
        
        $step = session('step');

        if (!$step) {
            $step_actual = 0;

            if($steps[3]){
                $steps[4] = true;
            }
            foreach ($steps as $key => $step) {
                if ($step) {
                    $step_actual = $key;
                }
            }
            session()->put('step', $step_actual);
        }

        // $enableNext = false;
        // $step_actual = 0;
        // foreach ($steps as $key => $step) {
        //     if ($step) {
        //         $step_actual = $key + 1;
        //     }
        //     // else{
        //     //     session()->put('step', 1);
        //     // }
        //     // $steps[$key + 1] = $enableNext;
        //     // break;
        // }
        // session()->put('step', $step_actual);
        // dd(session('step'), $step_actual);
        // session()->forget('step'); 
        // dd($step_actual);
        $this->data['steps'] = $steps;

        return view('pages.forms.index', $this->data);
    }

    public function create()
    {
        $this->data['forms'] = Forms::orderBy('date', 'desc')->get();
        return view('pages.forms.create', $this->data);
    }

    public function store(StoreRequest $request)
    {
        try {
            if ($request->status == 1) {
                $forms = Forms::all();

                foreach ($forms as $form) {
                    $form->status = 0;
                    $form->save();
                }
            }
            Forms::create([
                "title" => $request->title,
                "date" => $request->date,
                "status" => $request->status,
            ]);

            return redirect()->back()->with("toast_success", "Cadastro de formulário feito com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao fazer cadastro, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $form = Forms::find($id);
            $form->title = $request->title;
            $form->date = $request->date;
            $form->status = $request->status;

            $form->save();

            return redirect()->back()->with("toast_success", "Cadastro de formulário atualizado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao atualizar cadastro, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function persist(Request $request)
    {

        $actual_form = Forms::where('status', '1')->first();
        $user = auth()->user();
        $form_response = FormsResponse::where(['user_id' => $user->id, 'forms_id' => $actual_form->id])->first();
        $step = session('step');

        if ($form_response) {
            if (isset($request->title_action)) {
                $form_response->title_action = $request->title_action;
            }
            if (isset($request->type_action)) {
                $form_response->type_action = $request->type_action;
            }
            if (isset($request->action_modality)) {
                $form_response->action_modality = $request->action_modality;
            }
            if (isset($request->coordinator_name)) {
                $form_response->coordinator_name = $request->coordinator_name;
                session()->put('step', 3);
            }
            if (isset($request->coordinator_profile)) {
                $form_response->coordinator_profile = $request->coordinator_profile;
                session()->put('step', 3);
            }
            if (isset($request->coordinator_siape)) {
                $form_response->coordinator_siape = $request->coordinator_siape;
                session()->put('step', 3);
            }
            if (isset($request->coordinator_course)) {
                $form_response->coordinator_course = $request->coordinator_course;
                session()->put('step', 3);
            }
            if (isset($request->qtd_internal_audience)) {
                $form_response->qtd_internal_audience = $request->qtd_internal_audience;
            }
            if (isset($request->qtd_external_audience)) {
                $form_response->qtd_external_audience = $request->qtd_external_audience;
            }
            if (isset($request->advances_extensionist_action)) {
                $form_response->advances_extensionist_action = $request->advances_extensionist_action;
            }
            if (isset($request->social_technology_development)) {
                $form_response->social_technology_development = $request->social_technology_development;
            }
            if (isset($request->instrument_avaliation)) {
                $form_response->instrument_avaliation = $request->instrument_avaliation;
            }
            if (isset($request->was_finished)) {
                $form_response->was_finished = $request->was_finished;
            }

            $form_response->save();
        } else {
            FormsResponse::create([
                'forms_id' => $actual_form->id,
                'user_id' => $user->id,
                'title_action' => $request->title_action ?? null,
                'type_action' => $request->type_action ?? null,
                'action_modality' => $request->action_modality ?? null,
                'coordinator_name' => $request->coordinator_name ?? null,
                'coordinator_profile' => $request->coordinator_profile ?? null,
                'coordinator_siape' => $request->coordinator_siape ?? null,
                'coordinator_course' => $request->coordinator_course ?? null,
                'qtd_internal_audience' => $request->qtd_internal_audience ?? null,
                'qtd_external_audience' => $request->qtd_external_audience ?? null,
                'advances_extensionist_action' => $request->advances_extensionist_action ?? null,
                'social_technology_development' => $request->social_technology_development ?? null,
                'instrument_avaliation' => $request->instrument_avaliation ?? null,
                'was_finished' => $request->was_finished ?? 0,
            ]);

            session()->put('step', 2);
        }

        return redirect()->back();
    }

    public function advance()
    {
        $step = session('step');
        session()->put('step', $step + 1);

        return redirect()->back();
    }
}
