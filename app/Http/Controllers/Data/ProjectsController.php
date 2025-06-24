<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Projetcs\StoreRequest;
use App\Models\Parameters\Courses;
use App\Models\Parameters\Projects;
use App\Models\User;
use App\Repositories\Projects\ProjectsRepository;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    private $data = [];
    private $projetcsRepository;

    public function __construct(ProjectsRepository $projetcsRepository)
    {
        $this->projetcsRepository = $projetcsRepository;
    }

    public function index()
    {

        $this->data['projects'] = $this->projetcsRepository->getAll();

        return view('pages.projects.index', $this->data);
    }

    public function create()
    {
        $this->data['courses'] = Courses::all();
        $this->data['teachers'] = User::role('Professor')->get();

        return view('pages.projects.create', $this->data);
    }

    public function store(StoreRequest $request)
    {
        try {
            $this->projetcsRepository->create($request);
            return redirect()->back()->with("toast_success", "Projeto cadastrado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao cadastrar projeto. Por favor, tente novamente mais tarde.")->withInput();
        }
    }

    public function edit($uuid)
    {
        $this->data['courses'] = Courses::all();
        $this->data['teachers'] = User::role('Professor')->get();
        $this->data['project'] = $this->projetcsRepository->getById($uuid);

        return view('pages.projects.edit', $this->data);
    }

    public function update(StoreRequest $request, $uuid)
    {
        try {
            $this->projetcsRepository->update($request, $uuid);
            return redirect()->back()->with("toast_success", "Projeto atualizado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao atualizar projeto. Por favor, tente novamente mais tarde.")->withInput();
        }
    }
}
