<?php

namespace App\Repositories\Projects;


interface ProjectsRepository{
    public function getAll();

    public function getById($uuid);

    public function create($request);
    
    public function update($request, $uuid);
}