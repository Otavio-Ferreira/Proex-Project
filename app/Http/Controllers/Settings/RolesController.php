<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Spatie\RoleRequest;
use App\Repositories\Settings\Roles\RolesRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    private $data = [];
    private $rolesRepository;

    public function __construct(RolesRepository $rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
    }

    public function index()
    {
        
        $this->data['roles'] = Role::get();
        $this->data['permissions'] = Permission::all();

        return view('pages.roles.index')->with($this->data);
    }

    public function store(RoleRequest $request)
    {
        try {
            $this->rolesRepository->create($request);
            return redirect()->back()->with("toast_success", "Grupo adicionado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Error ao adicionar grupo, tente novamente em alguns instantes.");
        }
    }

    public function update(RoleRequest $request, $id)
    {
        try {
            $this->rolesRepository->update($request, $id);
            return redirect()->back()->with("toast_success", "Grupo editado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Error ao editar grupo, tente novamente em alguns instantes.");
        }

    }
}
