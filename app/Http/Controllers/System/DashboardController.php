<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Forms\Activitys;
use App\Models\Forms\Forms;
use App\Models\Parameters\Courses;
use App\Models\Parameters\Projects;
use App\Models\Persons\Persons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $ano = $request->input('ano'); // Ex: ?ano=2022

        $forms = Forms::query();

        if ($ano) {
            $forms->whereYear('date', $ano);
        }

        $dados = $forms->get();


        $cards_projeto = [
            [
                "title" => "Qtd. Projetos",
                "value" => Projects::count()
            ],
            [
                "title" => "Qtd. Cursos",
                "value" => Courses::count()
            ],
            [
                "title" => "Qtd. Professores",
                "value" => Persons::where('coordinator_profile', 'Docente')->count()
            ],
            [
                "title" => "Qtd. Formulários",
                "value" => Forms::count()
            ],
            [
                "title" => "Cidade com mais projetos",
                "value" => Activitys::select('address', DB::raw('count(*) as total'))
                ->groupBy('address')
                ->orderByDesc('total')
                ->limit(1)
                ->pluck('address')
                ->first()            
            ],
        ];

        $cards_acao = 

dd($cards_projeto);

        return view('dashboard.index', compact('dados', 'ano'));
    }
}
