<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Models\Parameters\Projects;
use App\Models\Persons\Persons;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $data = [];

    public function index()
    {
        $user = Auth::user();

        $this->data['person'] = Persons::where('user_id', $user->id)->first();
        $this->data['user'] = $user;

        $diff = $this->data['user']->updated_at->diffInMonths();

        if ($diff < 1) {
            $progress = '100%';
        } elseif ($diff < 2) {
            $progress = '90%';
        } elseif ($diff < 3) {
            $progress = '60%';
        } elseif ($diff < 4) {
            $progress = '50%';
        } elseif ($diff < 5) {
            $progress = '40%';
        } elseif ($diff < 6) {
            $progress = '30%';
        } elseif ($diff < 7) {
            $progress = '20%';
        } elseif ($diff < 8) {
            $progress = '10%';
        } else {
            $progress = '1%';
        }

        $this->data['progress'] = $progress;
        $this->data['diff'] = $diff;

        $profile = 100;

        if ($this->data['person']) {
            if ($this->data['user']->persons->coordinator_name == null) {
                $profile -= 20;
                
            }
            if ($this->data['user']->persons->coordinator_profile == null) {
                $profile -= 20;
            }
            if ($this->data['user']->persons->coordinator_siape == null) {
                $profile -= 20;
            }
            if ($this->data['user']->persons->coordinator_course == null) {
                $profile -= 20;
            }
        } else {
            $profile -= 60;
        }

        $this->data['profile'] = $profile;

        $role = $user->active_role;

        $this->data['tasks'] = [];
        if ($role == "Coordenador") {
            $responses = FormsResponse::where(['user_id' => $user->id])->whereIn('was_finished', [0, 2])->get();
            $tasks = [];
            foreach ($responses as $key => $response) {
                $steps = [
                    isset($response->activitys) && count($response->activitys) > 0,
                    isset($response->qtd_internal_audience) && isset($response->qtd_external_audience),
                    isset($response->advances_extensionist_action),
                    // isset($response->internal_partners) && count($response->internal_partners) > 0,
                    // isset($response->external_partners) && count($response->external_partners) > 0,
                    isset($response->extension_actions) && count($response->extension_actions) > 0,
                    isset($response->social_technology_development),
                    isset($response->social_medias) && count($response->social_medias) > 0,
                    isset($response->images) && count($response->images) > 0,
                    isset($response->instrument_avaliation),
                ];

                $form = Forms::find($response->forms_id);
                $progress = number_format(collect($steps)->filter()->count() * 12.5);

                if ($form->status = 1) {
                    if ($response->was_finished == 0) {
                        $tasks[$key]['description'] = $progress == 100 ? "Enviar relatório" : "Completar relatório";
                        $tasks[$key]['progress'] = $progress;
                        $tasks[$key]['response'] = $response;
                        $tasks[$key]['type'] = 1;
                    }
                    if ($response->was_finished == 2) {
                        $tasks[$key]['description'] = $progress == 100 ? "Corrigir relatório" : "Completar relatório";
                        $tasks[$key]['progress'] = $progress;
                        $tasks[$key]['response'] = $response;
                        $tasks[$key]['type'] = 1;
                    }
                }
                $this->data['form'] = $form;
            }
            $this->data['tasks'] = $tasks;
        } elseif ($role == "Administrador") {
            // $users_to_check = User::whereHas('persons', function ($q) {
            //     $q->where('coordinator_profile', 'Técnico Administrativo');
            // })->whereHas('roles', function ($q) {
            //     $q->where('name', 'Visitante');
            // })->get();
            // $tasks = [];
            // foreach ($users_to_check as $key => $user) {
            //     $tasks[$key]['type'] = 2;
            //     $tasks[$key]['description'] = "Mudar o grupo desse usuário para técnico administrativo.";
            //     $tasks[$key]['user'] = $user;
            // }
            // $this->data['tasks'] = $tasks;
        }

        return view('pages.home.index', $this->data);
    }
}
