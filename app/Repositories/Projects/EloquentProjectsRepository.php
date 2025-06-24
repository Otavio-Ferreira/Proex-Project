<?php

namespace App\Repositories\Projects;

use App\Models\Parameters\Courses;
use App\Models\Parameters\Projects;
use App\Models\Persons\Persons;

class EloquentProjectsRepository implements ProjectsRepository
{
    public function getAll()
    {
        return Projects::orderBy('created_at', 'desc')->get();
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
            'status' => $request->status
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
        $projetc->save();

        return $projetc;
    }
}
