<?php

namespace App\Http\Controllers\System\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Persons\StoreRequest;
use App\Models\Parameters\Courses;
use App\Repositories\Persons\PersonsRepository;
use App\Services\Persons\PersonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $data = [];
    private $personsRepository;
    private $personService;

    public function __construct(
        PersonsRepository $personsRepository,
        PersonService $personService
    )
    {
        $this->personsRepository = $personsRepository;
        $this->personService = $personService;
    }

    public function index(){
        $user = Auth::user();

        $this->data['base_courses'] = Courses::all();
        $this->data['person'] = $this->personsRepository->get($user->id);
        $this->data['user'] = $user;

        return view('pages.profile.index', $this->data);
    }

    public function store(StoreRequest $request){
        return $this->personService->storeResponse($request);
    }
}
