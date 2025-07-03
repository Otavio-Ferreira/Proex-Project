<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Forms\Activitys;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Models\Parameters\Courses;
use App\Models\Parameters\Projects;
use App\Models\Persons\Persons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    private $data = [];

    public function index(Request $request)
    {

        $form_select_uuid = $request->input('form');

        $cards_projeto = [
            [
                "title" => "Qtd. Projetos",
                "value" => Projects::count(),
                'color' => 'green',
                'icon' => 'ti-directions'
            ],
            [
                "title" => "Qtd. Cursos",
                "value" => Courses::count(),
                'color' => 'primary',
                'icon' => 'ti-certificate'
            ],
            [
                "title" => "Qtd. Servidores",
                "value" => Persons::where('coordinator_profile', 'Docente')->count(),
                'color' => 'cyan',
                'icon' => 'ti-user'
            ],
            [
                "title" => "Cidade com mais projetos",
                "value" => $this->getCityWhitMoreProjects($form_select_uuid),
                'color' => 'orange',
                'icon' => 'ti-building-community'
            ],
        ];

        $cards_acao = [
            [
                "title" => "Quantidade por tipo de ações.",
                "cards" => [
                    [
                        "title" => "Projeto",
                        "value" => $form_select_uuid ? (FormsResponse::where(["forms_id" => $form_select_uuid, "type_action" => "Projeto"])->count()) : (FormsResponse::where("type_action", "Projeto")->count()),
                    ],
                    [
                        "title" => "Programa",
                        "value" => $form_select_uuid ? (FormsResponse::where(["forms_id" => $form_select_uuid, "type_action" => "Programa"])->count()) : (FormsResponse::where("type_action", "Programa")->count()),
                    ]
                ]
            ],
            [
                "title" => "Quantidade por modalidade de ações.",
                "cards" => [
                    [
                        "title" => "UFCA Itinerante",
                        "value" => $form_select_uuid ? FormsResponse::where(["forms_id" => $form_select_uuid, "action_modality" => "UFCA Itinerante"])->count() : FormsResponse::where("action_modality", "UFCA Itinerante")->count(),
                    ],
                    [
                        "title" => "PROPE",
                        "value" => $form_select_uuid ? FormsResponse::where(["forms_id" => $form_select_uuid, "action_modality" => "PROPE"])->count() : FormsResponse::where("action_modality", "PROPE")->count(),
                    ],
                    [
                        "title" => "Ampla Concorrência",
                        "value" => $form_select_uuid ? FormsResponse::where(["forms_id" => $form_select_uuid, "action_modality" => "Ampla Concorrência"])->count() : FormsResponse::where("action_modality", "Ampla Concorrência")->count(),
                    ]
                ]
            ],
        ];

        $cards_alcance = [
            [
                "title" => "Quantidade de público interno alcaçado.",
                "value" => $form_select_uuid ? FormsResponse::where('forms_id', $form_select_uuid)->sum("qtd_internal_audience") : FormsResponse::sum("qtd_internal_audience")
            ],
            [
                "title" => "Quantidade de público externo alcaçado.",
                "value" => $form_select_uuid ? FormsResponse::where('forms_id', $form_select_uuid)->sum("qtd_external_audience") : FormsResponse::sum("qtd_external_audience")
            ],
        ];

        $ranking_course = $form_select_uuid ? FormsResponse::where('forms_id', $form_select_uuid)->selectRaw('coordinator_course, COUNT(*) as total')
            ->groupBy('coordinator_course')
            ->orderByDesc('total')
            ->with('course')->get() : FormsResponse::selectRaw('coordinator_course, COUNT(*) as total')
            ->groupBy('coordinator_course')
            ->orderByDesc('total')
            ->with('course')->get();



        $ranking_projects = FormsResponse::with('form')->get()->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->form->date)->format('Y');
        })->map(function ($group, $year) {
            return [
                'ano' => $year,
                'total' => $group->count(),
            ];
        })->sortBy('ano')->values();


        $this->data["forms"] = Forms::orderBy('date','desc')->get();
        $this->data["cards_projeto"] = $cards_projeto;
        $this->data["cards_acao"] = $cards_acao;
        $this->data["cards_alcance"] = $cards_alcance;
        $this->data["ranking_course"] = $ranking_course;
        $this->data["ranking_projects"] = $ranking_projects;

        $data = Activitys::select('address', DB::raw('count(*) as total'))
        ->groupBy('address')
        ->get();

        $citiesData = $data->map(function ($item) {
            return [
                'name' => $item->address,
                'value' => $item->total,
            ];
        });
        $this->data['chartDataCity'] = $citiesData->toJson();        
        // dd($chartData);
        return view('pages.dashboard.index', $this->data);
    }

    public function getCityWhitMoreProjects($form_select_uuid)
    {

        $enderecoMaisFrequente = null;

        if (!empty($form_select_uuid)) {
            // Busca o formulário pelo UUID
            $form = Forms::where('id', $form_select_uuid)->first();

            if ($form) {
                // Pega os IDs de respostas ligadas ao formulário
                $formsResponseIds = FormsResponse::where('forms_id', $form->id)->pluck('id');

                // Consulta para pegar o endereço mais comum apenas nas respostas desse formulário
                return $enderecoMaisFrequente = Activitys::whereIn('response_forms_id', $formsResponseIds)
                    ->select('address', DB::raw('count(*) as total'))
                    ->groupBy('address')
                    ->orderByDesc('total')
                    ->limit(1)
                    ->pluck('address')
                    ->first();
            }
        }

        // Se não passou o UUID ou não achou o formulário, faz a consulta geral
        if (empty($enderecoMaisFrequente)) {
            return $enderecoMaisFrequente = Activitys::select('address', DB::raw('count(*) as total'))
                ->groupBy('address')
                ->orderByDesc('total')
                ->limit(1)
                ->pluck('address')
                ->first();
        }
    }

}
