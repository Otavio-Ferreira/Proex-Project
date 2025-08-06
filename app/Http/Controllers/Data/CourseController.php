<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\StoreRequest;
use App\Http\Requests\Courses\UpdateRequest;
use App\Models\Parameters\Courses;
use App\Services\Courses\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $data = [];
    private $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }


    public function index()
    {
        $this->data['courses'] = Courses::orderBy('created_at', 'desc')->get();

        return view('pages.courses.index', $this->data);
    }

    public function store(StoreRequest $request)
    {
        return $this->courseService->storeResponse($request);
    }

    public function update(UpdateRequest $request, $id)
    {
        return $this->courseService->updateResponse($request, $id);
    }

    public function destroy($id)
    {
        return $this->courseService->destroyResponse($id);
    }
}
