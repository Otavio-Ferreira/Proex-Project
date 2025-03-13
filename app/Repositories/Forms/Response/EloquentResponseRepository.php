<?php

namespace App\Repositories\Forms\Response;

use App\Http\Requests\Users\StoreRequest;
use App\Models\Forms\FormsResponse;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EloquentResponseRepository implements ResponseRepository
{
    public function getUserFormResponse($user_id, $form_id)
    {
        return FormsResponse::where(['user_id' => $user_id, 'forms_id' => $form_id])->first();
    }

    public function update($form_response, $request)
    {
        if (isset($request->title_action)) {
            $form_response->title_action = $request->title_action;
            session()->put('step', 2);
        }
        if (isset($request->type_action)) {
            $form_response->type_action = $request->type_action;
            session()->put('step', 2);
        }
        if (isset($request->action_modality)) {
            $form_response->action_modality = $request->action_modality;
            session()->put('step', 2);
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
            session()->put('step', 5);
        }
        if (isset($request->qtd_external_audience)) {
            $form_response->qtd_external_audience = $request->qtd_external_audience;
            session()->put('step', 5);
        }
        if (isset($request->advances_extensionist_action)) {
            $form_response->advances_extensionist_action = $request->advances_extensionist_action;
            session()->put('step', 6);
        }
        if (isset($request->social_technology_development)) {
            $form_response->social_technology_development = $request->social_technology_development;
            session()->put('step', 10);
        }
        if (isset($request->instrument_avaliation)) {
            $form_response->instrument_avaliation = $request->instrument_avaliation;
        }

        $form_response->save();
    }

    public function set($request, $form_id, $user_id)
    {
        FormsResponse::create([
            'forms_id' => $form_id,
            'user_id' => $user_id,
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
    }

    public function finish($form_response){
        $form_response->was_finished = 1;
        $form_response->save();
    }

}
