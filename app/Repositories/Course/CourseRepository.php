<?php

namespace App\Repositories\Course;


interface CourseRepository{
    public function set($request);

    public function get($id);

    public function update($request, $id);

    public function delete($id);
}