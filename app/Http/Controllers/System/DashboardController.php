<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Forms\Activitys;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Models\Parameters\Courses;
use App\Models\Parameters\Projects;
use App\Repositories\Course\CourseRepository;
use App\Repositories\Forms\Response\ResponseRepository;
use App\Repositories\Projects\ProjectsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    private $data = [];
    private $responseRepository;
    private $projectsRepository;
    private $coursesRepository;

    public function __construct(
        ResponseRepository $responseRepository,
        ProjectsRepository $projectsRepository,
        CourseRepository $coursesRepository
    ) {
        $this->responseRepository = $responseRepository;
        $this->projectsRepository = $projectsRepository;
        $this->coursesRepository = $coursesRepository;
    }

    public function index(Request $request)
    {

        $filter_year = $request->input('year');
        $filter_form = $request->input('form');
        $filter_course = $request->input('course');
        $filter_status = $request->input('status');
        session([
            'filter_year' => $filter_year,
            'filter_form' => $filter_form,
            'filter_course' => $filter_course,
            'filter_status' => $filter_status,
        ]);

        $cards = [
            [
                "title" => "Total de pessoas",
                "description" => "Quantidade de público interno alcaçado.",
                "value" => $this->responseRepository->getByFilter($filter_year, $filter_form, $filter_course, $filter_status, null, null)->sum('qtd_internal_audience')
            ],
            [
                "title" => "Total de pessoas",
                "description" => "Quantidade de público externo alcaçado.",
                "value" => $this->responseRepository->getByFilter($filter_year, $filter_form, $filter_course, $filter_status, null, null)->sum('qtd_external_audience')
            ],
            [
                "title" => "Total de trabalhos",
                "description" => "Quantidade total de trabalhos cadastrados.",
                "value" => $this->projectsRepository->getByFilter($filter_year, $filter_course, $filter_status, null, null)->count()
            ],
            [
                "title" => "Total de cursos",
                "description" => "Quantidade de cursos com trabalhos.",
                "value" => $this->coursesRepository->getByFilter($filter_status)->count()
            ],
        ];

        $cards_acao = [
            [
                "title" => "Quantidade por tipo de ações.",
                "cards" => [
                    [
                        "title" => "Projeto",
                        "value" => $this->projectsRepository->getByFilter($filter_year, $filter_course, $filter_status, "Projeto", null)->count(),
                        // 'value' => $this->responseRepository->getByFilter($filter_year, $filter_form, $filter_course, $filter_status, 'Projeto', null)->count()
                    ],
                    [
                        "title" => "Programa",
                        "value" => $this->projectsRepository->getByFilter($filter_year, $filter_course, $filter_status, "Programa", null)->count(),
                        // 'value' => $this->responseRepository->getByFilter($filter_year, $filter_form, $filter_course, $filter_status, 'Programa', null)->count()
                    ]
                ]
            ],
            [
                "title" => "Quantidade por modalidade de ações.",
                "cards" => [
                    [
                        "title" => "UFCA Itinerante",
                        "value" => $this->projectsRepository->getByFilter($filter_year, $filter_course, $filter_status, null, "UFCA Itinerante")->count(),
                        // 'value' => $this->responseRepository->getByFilter($filter_year, $filter_form, $filter_course, $filter_status, null, 'UFCA Itinerante')->count()
                    ],
                    [
                        "title" => "PROPE",
                        "value" => $this->projectsRepository->getByFilter($filter_year, $filter_course, $filter_status, null, "PROPE")->count(),
                        // 'value' => $this->responseRepository->getByFilter($filter_year, $filter_form, $filter_course, $filter_status, null, 'PROPE')->count()
                    ],
                    [
                        "title" => "Ampla Concorrência",
                        "value" => $this->projectsRepository->getByFilter($filter_year, $filter_course, $filter_status, null, "Ampla Concorrência")->count(),
                        // 'value' => $this->responseRepository->getByFilter($filter_year, $filter_form, $filter_course, $filter_status, null, 'Ampla Concorrência')->count()
                    ]
                ]
            ],
        ];

        $query = $this->projectsRepository->getByFilter(
            $filter_year,
            null,
            $filter_status,
            null,
            null
        );

        $ranking_course = $query->selectRaw('projects.course, courses.name as course_name, COUNT(projects.id) as total')
            // ->join('projects', 'forms_responses.project_id', '=', 'projects.id')
            ->join('courses', 'projects.course', '=', 'courses.id')
            ->groupBy('projects.course', 'courses.name')
            ->orderByDesc('total')
            ->get();

        $query_two = $this->projectsRepository->getByFilter(
            null,
            $filter_course,
            $filter_status,
            null,
            null
        );

        $ranking_projects = $query_two->get()->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->created_at)->format('Y');
        })->map(function ($group, $year) {
            return [
                'ano' => $year,
                'total' => $group->count(),
            ];
        })->sortBy('ano')->values();


        $this->data["forms"] = Forms::orderBy('date', 'desc')->get();
        $this->data["courses"] = Courses::orderBy('name', 'asc')->get();
        $this->data["cards_acao"] = $cards_acao;
        $this->data["cards"] = $cards;
        $this->data["ranking_course"] = $ranking_course;
        $this->data["ranking_projects"] = $ranking_projects;

        $data = Activitys::select(
            'activitys.response_forms_id',
            'activitys.address',
            'activitys.latitude',
            'activitys.longitude',
            DB::raw('count(*) as total')
        )
        ->groupBy('activitys.address', 'activitys.latitude', 'activitys.longitude', 'activitys.response_forms_id')
        ->get();
    
        $markers = $data->map(function ($item) {
            return [
                'lat' => $item->latitude,
                'lng' => $item->longitude,
                'address' => $item->address,
                'total' => $item->total,
                'title' => Projects::find(FormsResponse::find($item->response_forms_id)->project_id)->title,
            ];
        });
        
        $this->data['markers'] = $markers;

        return view('pages.dashboard.index', $this->data);
    }
}
