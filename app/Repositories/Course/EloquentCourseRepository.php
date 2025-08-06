<?php

namespace App\Repositories\Course;

use App\Models\Parameters\Courses;
use App\Models\Persons\Persons;

class EloquentCourseRepository implements CourseRepository
{
    public function set($request)
    {
        $course = Courses::create([
            "name" => $request->name,
        ]);
        return $course;
    }

    public function get($id)
    {
        return Courses::find($id);
    }

    public function update($request, $id)
    {
        $course = Courses::find($id);

        if ($course) {
            $course->name = $request->name;
            $course->status = $request->status;
            $course->save();
        }

        return $course;
    }

    public function delete($id)
    {
        $course = Courses::find($id);
        $course->delete();
    }

    public function getByFilter($filter_status){
        $query = Courses::query();

        if (isset($filter_status)) {
            $query->where('status', $filter_status);
        }

        return $query;
    }
}
