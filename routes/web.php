<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Settings\PermissionsController;
use App\Http\Controllers\Settings\RolesController;
use App\Http\Controllers\Settings\UsersController;
use App\Http\Controllers\System\HomeController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->to_route('login');
});


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login/enviar', [LoginController::class, 'store'])->name('login.store');

Route::get('login/resetar', [LoginController::class, 'reset'])->name('login.reset');
Route::post('login/solicitar', [LoginController::class, 'send'])->name('login.send');

Route::get('login/editar/{token}', [LoginController::class, 'edit'])->name('login.edit');
Route::get('login/registrar/{token}', [LoginController::class, 'register'])->name('login.register');
Route::post('login/atualizar/{token}', [LoginController::class, 'update'])->name('login.update');

Route::get('login/cadastro', [LoginController::class, 'first'])->name('login.first');
Route::post('login/cadastrar', [LoginController::class, 'fill'])->name('login.fill');

Route::middleware(Authenticate::class)->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home.index');
    Route::post('/dashboard', [HomeController::class, 'index']);

    Route::group(['middleware' => ['auth', 'permission:adicionar_grupo']], function () {
        Route::get('gupos', [RolesController::class, 'index'])->name('roles.index');
        Route::post('grupos/adicionar', [RolesController::class, 'store'])->name('roles.store');
        Route::post('grupos/atualizar/{id}', [RolesController::class, 'update'])->name('roles.update');
    });

    // Route::group(['middleware' => ['auth', 'permission:adicionar_permissões']], function () {
    //     Route::get('permissoes', [PermissionsController::class, 'index'])->name('permissions.index');
    //     Route::post('permissoes/adicionar', [PermissionsController::class, 'store'])->name('permissions.store');
    //     Route::post('permissoes/atualizar/{id}', [PermissionsController::class, 'update'])->name('permissions.update');
    // });
    
    Route::group(['middleware' => ['auth', 'permission:adicionar_usuário']], function () {
        Route::get('usuarios', [UsersController::class, 'index'])->name('users.index');
        Route::post('usuarios/adicionar', [UsersController::class, 'store'])->name('users.store');
        Route::post('usuarios/atualizar/{id}', [UsersController::class, 'update'])->name('users.update');
        Route::delete('usuarios/deletar/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    });

    Route::get('users/sair', [UsersController::class, 'logout'])->name('logout');
});
