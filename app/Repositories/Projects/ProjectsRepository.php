<?php

namespace App\Repositories\Projects;


interface ProjectsRepository
{
    public function getAll();

    public function getAllPaginate($request = null, $id = null);

    public function getById($uuid);

    public function getByUserId($uuid, $request);

    public function create($request);

    public function update($request, $uuid);

    public function getByFilter($filter_year, $filter_course, $filter_status, $type, $modality);
}
