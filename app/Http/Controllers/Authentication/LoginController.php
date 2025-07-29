<?php

namespace App\Http\Controllers\Authentication;

use App\Events\Autenticator\NewUser;
use App\Events\Autenticator\TokenCreated;
use App\Events\Autenticator\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Autenticator;
use App\Http\Requests\Authentication\FillRequest;
use App\Http\Requests\Authentication\ResetRequest;
use App\Http\Requests\Authentication\SendRequest;
use App\Models\Authentication\Tokens;
use App\Models\User;
use App\Repositories\Authentication\LoginRepository;
use App\Repositories\Settings\Roles\RolesRepository;
use App\Repositories\Settings\Users\UsersRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\Autenticator\EmailToSetPassword as AutenticatorEmailToSetPassword;
use Illuminate\Support\Facades\Mail;


class LoginController extends Controller
{
    private $loginRepository;
    private $usersRepository;
    private $rolesRepository;

    public function __construct(LoginRepository $loginRepository, UsersRepository $usersRepository, RolesRepository $rolesRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->rolesRepository = $rolesRepository;
        $this->loginRepository = $loginRepository;
    }

    public function index()
    {
        return view('pages.authentication.index');
    }

    public function store(Request $request)
    {

        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {

            if (Auth::user()->status == 1) {
                return redirect()->route('home.index');
            } else {
                Auth::logout();
                return back()->with("toast_error", "verifique se o email e senha foram digitados corretamente.")->withInput();
            }
        }

        return back()->with("toast_error", "verifique se o email e senha foram digitados corretamente.")->withInput();
    }

    public function reset()
    {
        return view('pages.authentication.reset');
    }

    public function edit(Tokens $token)
    {
        if (isset($token) && $token->status == 1) {
            return view('pages.authentication.edit')->with('token_id', $token->id);
        }

        return to_route('login');
    }

    public function send(SendRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            try {

                $data = $this->loginRepository->createToken($user, "reset_password");

                TokenCreated::dispatch(
                    $data['name'],
                    $data['email'],
                    $data['time'],
                    $data['token'],
                    $data['title'],
                );

                return redirect()->back()->with("toast_success", "Verifique a caixa de entrada do seu email.");
            } catch (\Throwable $th) {
                return redirect()->back()->with("toast_error", "Erro ao enviar o email, tente novamente em alguns instantes.")->withInput();
            }
        }

        return redirect()->back()->with("toast_warning", "Erro ao enviar o email. Verifique se o email digitado está correto.")->withInput();
    }

    public function update(ResetRequest $request, Tokens $token)
    {
        if (isset($token) && $token->status == 1) {
            try {
                $this->loginRepository->changePassword($request, $token);

                return to_route('login')->with("toast_success", "Senha atualizada, tente fazer login.");
            } catch (\Throwable $th) {
                return redirect()->back()->with("toast_error", "Erro, tente novamente em alguns instantes.")->withInput();
            }
        }

        return redirect()->back()->with("toast_error", "Error ao tentar alterar senha, tente novamente em alguns instantes.")->withInput();
    }

    public function register(Tokens $token)
    {
        if (isset($token) && $token->status == 1) {
            return view('pages.authentication.register')->with('token_id', $token->id);
        }

        return to_route('login');
    }

    public function first()
    {
        return view("pages.authentication.first");
    }

    public function fill(FillRequest $request)
    {

        try {
            $user = $this->usersRepository->set($request);
            $user->assignRole("Visitante");
            $data = $this->loginRepository->createToken($user, "first_access");

            $mail = new AutenticatorEmailToSetPassword(
                $data['name'],
                $data['email'],
                $data['time'],
                $data['token'],
                $data['title']
            );

            Mail::to($user)->send($mail);

            return to_route('page.success')->with("message", "Cadastro feito com sucesso, verifique sua caixa de email.");
        } catch (\Throwable $th) {
            if (!empty($user)) {
                $user->forceDelete();
            }
            return redirect()->back()->with("toast_error", "Erro ao fazer cadastro, verifique se digitou o email corretamente e tente novamente em alguns instantes.")->withInput();
        }
    }
}
