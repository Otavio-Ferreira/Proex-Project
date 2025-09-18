<?php

namespace App\Http\Controllers\Settings;

use App\Events\Autenticator\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Models\User;
use App\Repositories\Authentication\LoginRepository;
use App\Repositories\Settings\Roles\RolesRepository;
use App\Repositories\Settings\Users\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    private $data = [];
    private $usersRepository;
    private $rolesRepository;
    private $loginRepository;

    public function __construct(UsersRepository $usersRepository, RolesRepository $rolesRepository, LoginRepository $loginRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->rolesRepository = $rolesRepository;
        $this->loginRepository = $loginRepository;
    }

    public function index(Request $request)
    {
        $this->data['users'] = $this->usersRepository->getAllPaginate($request);
        $this->data['roles'] = Role::all();
        $this->data['status'] = [
            [
                "color" => "danger",
                "name" => "Inativo"
            ],
            [
                "color" => "success",
                "name" => "Ativo"
            ],
            [
                "color" => "primary",
                "name" => "Pré-Cadastrado"
            ],
        ];

        return view('pages.users.index')->with($this->data);
    }

    public function store(StoreRequest $request)
    {
        try {

            $user = $this->usersRepository->set($request);
            $this->rolesRepository->set($user, $request);

            $data = $this->loginRepository->createToken($user, "first_access");

            UserCreated::dispatch(
                $data['name'],
                $data['email'],
                $data['time'],
                $data['token'],
                $data['title'],
            );

            return redirect()->back()->with("toast_success", "Usuário inserido, peça-o para verificar o email para cadastrar uma senha.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao inserir usuário, tente novamente em alguns instantes.");
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->status = $request->status;

            $user->save();

            if ($request->role) {
                $user->syncRoles([$request->role]);
            }

            return redirect()->back()->with('toast_success', 'Usuário atualizado com sucesso.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', 'Erro ao atualizar usuário, tente novamente em alguns instantes');
        }
    }

    public function destroy($id)
    {
        try {
            $this->usersRepository->delete($id);
            return redirect()->back()->with('toast_success', 'Registro removido com sucesso.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', 'Registro não encontrado.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }

    public function changePortal(Role $portal)
    {
        try {
            $portals = Auth::user()->roles;
            
            if ($portals->contains($portal)) {
                $user = User::find(Auth::user()->id);
                $user->active_role = $portal->name;
                $user->save();
            }

            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
