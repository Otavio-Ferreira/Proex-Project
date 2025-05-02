<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Parameters\Projects;
use App\Models\Persons\Persons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $data = [];
    
    public function index(){
        $user = Auth::user();

        $this->data['person'] = Persons::where('user_id', $user->id)->first();
        $this->data['user'] = $user;
        
        return view('pages.home.index', $this->data);
    }
}
