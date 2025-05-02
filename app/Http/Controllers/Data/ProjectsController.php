<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Parameters\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    private $data = [];
    
    public function index(){

        $this->data['projects'] = Projects::all();
        
        return view('pages.projects.index', $this->data);
    }
}
