<?php

namespace App\Repositories\Projects;

use App\Models\Parameters\Courses;
use App\Models\Parameters\Projects;
use App\Models\Persons\Persons;
use Illuminate\Support\Str;

class EloquentProjectsRepository implements ProjectsRepository
{
    public function getAll()
    {
        return Projects::orderBy('created_at', 'desc')->get();
    }

    public function getAllPaginate($request = null, $id = null)
    {
        $query = Projects::query();

        if ($id) {
            $query->where('id_submit', $id);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%')
                    ->orWhere('modality', 'like', '%' . $search . '%')
                    ->orWhere('start_date', 'like', '%' . $search . '%')
                    ->orWhere('end_date', 'like', '%' . $search . '%')
                    ->orWhere('id_atividade', 'like', '%' . $search . '%')
                    ->orWhere('id_projeto', 'like', '%' . $search . '%')
                    ->orWhere('year', 'like', '%' . $search . '%')
                    ->orWhere('thematic_area', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($coordinatorQuery) use ($search) {
                        $coordinatorQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        return $query->orderBy('title', 'asc')->paginate(20);
    }

    public function getById($uuid)
    {
        return Projects::find($uuid);
    }

    public function create($request)
    {
        $projetc = Projects::create([
            'title' => $request->title,
            'type' => $request->type,
            'modality' => $request->modality,
            'course' => $request->course,
            'coordinator' => $request->teacher,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'year' => $request->year,
            'id_atividade' => $request->id_atividade,
            'id_projeto' => $request->id_projeto,
            'thematic_area' => $request->thematic_area,
            'type_submit' => 'store',
            'id_submit' => Str::uuid(),
        ]);

        return $projetc;
    }

    public function update($request, $uuid)
    {
        $projetc = $this->getById($uuid);

        $projetc->title = $request->title;
        $projetc->type = $request->type;
        $projetc->modality = $request->modality;
        $projetc->course = $request->course;
        $projetc->coordinator = $request->teacher;
        $projetc->start_date = $request->start_date;
        $projetc->end_date = $request->end_date;
        $projetc->status = $request->status;
        $projetc->year = $request->year;
        $projetc->id_atividade = $request->id_atividade;
        $projetc->id_projeto = $request->id_projeto;
        $projetc->thematic_area = $request->thematic_area;
        $projetc->save();

        return $projetc;
    }

    public function getByUserId($uuid, $request)
    {
        $query = Projects::where('coordinator', $uuid);

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%')
                    ->orWhere('modality', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(5);
    }

    public function getByFilter($filter_year, $filter_course, $filter_status, $type, $modality)
    {
        $query = Projects::query();

        if (isset($filter_year)) {
            $query->whereYear('projects.start_date', $filter_year);
        }
        if (isset($filter_course)) {
            $query->where('projects.course', $filter_course);
        }
        if (isset($filter_status)) {
            $query->where('projects.status', $filter_status);
        }
        if (isset($type)) {
            $query->where('projects.type', $type);
        }
        if (isset($modality)) {
            $query->where('projects.modality', $modality);
        }
        return $query;
    }
}
