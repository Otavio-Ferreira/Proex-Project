<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Forms\Activitys;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Models\Parameters\Courses;
use App\Models\Parameters\Parameters;
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
                "title" => "Total de Centros/Departamentos",
                "description" => "Quantidade de cursos com trabalhos.",
                "value" => $this->coursesRepository->getByFilter($filter_status)->count()
            ],
        ];

        $modalidades = Parameters::where(['function' => 'MODALIDADE', 'status' => 1])->get();
        $tipos = Parameters::where(['function' => 'TIPO', 'status' => 1])->get();

        $cards_acao = [
            [
                "title" => "Quantidade por tipo de ações.",
            ],
            [
                "title" => "Quantidade por modalidade de ações.",
            ],
        ];

        foreach ($tipos as $key => $tipo) {
            $cards_acao[0]["cards"][$key] = [
                "title" => $tipo->value,
                "value" => $this->projectsRepository->getByFilter($filter_year, $filter_course, $filter_status, $tipo->value, null)->count(),
            ];
        }

        foreach ($modalidades as $key => $modalidade) {
            $cards_acao[1]["cards"][$key] = [
                "title" => $modalidade->value,
                "value" => $this->projectsRepository->getByFilter($filter_year, $filter_course, $filter_status, null, $modalidade->value)->count(),
            ];
        }

        $query = $this->projectsRepository->getByFilter(
            $filter_year,
            null,
            $filter_status,
            null,
            null
        );

        $ranking_course = $query->selectRaw('projects.course, courses.name as course_name, COUNT(projects.id) as total')
            //->join('projects', 'forms_responses.project_id', '=', 'projects.id')
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
