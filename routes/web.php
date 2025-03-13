<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Settings\PermissionsController;
use App\Http\Controllers\Settings\RolesController;
use App\Http\Controllers\Settings\UsersController;
use App\Http\Controllers\System\Forms\ActivityController;
use App\Http\Controllers\System\Forms\ExtencionActionsController;
use App\Http\Controllers\System\Forms\ExternalPartnersController;
use App\Http\Controllers\System\Forms\FormsResponseController;
use App\Http\Controllers\System\Forms\ImagesController;
use App\Http\Controllers\System\Forms\InternalPartnersController;
use App\Http\Controllers\System\Forms\SocialMediaController;
use App\Http\Controllers\System\Forms\FormsController;
use App\Http\Controllers\System\HomeController;
use App\Http\Middleware\Authenticate;
use App\Models\Forms\Images;
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
    return redirect()->route('login');
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

    Route::group(['middleware' => ['auth', 'permission:adicionar_cursos']], function () {
        Route::get('cursos', [RolesController::class, 'index'])->name('courses.index');
        // Route::post('grupos/adicionar', [RolesController::class, 'store'])->name('roles.store');
        // Route::post('grupos/atualizar/{id}', [RolesController::class, 'update'])->name('roles.update');
    });
    Route::group(['middleware' => ['auth', 'permission:adicionar_projetos']], function () {
        Route::get('projetos', [RolesController::class, 'index'])->name('projects.index');
        // Route::post('grupos/adicionar', [RolesController::class, 'store'])->name('roles.store');
        // Route::post('grupos/atualizar/{id}', [RolesController::class, 'update'])->name('roles.update');
    });
    
    Route::group(['middleware' => ['auth', 'permission:adicionar_formulário']], function () {
        Route::get('formulario/cadastro', [FormsController::class, 'create'])->name('forms.create');
        Route::post('formulario/adicionar', [FormsController::class, 'store'])->name('forms.store');
        Route::post('formulario/editar/{id}', [FormsController::class, 'update'])->name('forms.update');
        
    });
    
    Route::group(['middleware' => ['auth', 'permission:responder_formulário']], function () {
        Route::get('formulario', [FormsResponseController::class, 'index'])->name('forms.index');
        Route::get('formulario/avançar/{actual_step}', [FormsResponseController::class, 'advance'])->name('forms.advance');
        Route::get('formulario/retornar/{actual_step}', [FormsResponseController::class, 'return'])->name('forms.return');
        Route::post('formulario/persistir', [FormsResponseController::class, 'persist'])->name('forms.persist');
        Route::delete('formulario/finalizar', [FormsResponseController::class, 'finish'])->name('forms.finish');
    
        Route::post('atividade/adicionar', [ActivityController::class, 'store'])->name('activitys.store');
        Route::post('atividade/editar/{id}', [ActivityController::class, 'update'])->name('activitys.update');
        Route::delete('atividade/deletar/{id}', [ActivityController::class, 'destroy'])->name('activitys.destroy');
    
        Route::post('parceiro/interno/adicionar', [InternalPartnersController::class, 'store'])->name('internalPartners.store');
        Route::post('parceiro/interno/editar/{id}', [InternalPartnersController::class, 'update'])->name('internalPartners.update');
        Route::delete('parceiro/interno/deletar/{id}', [InternalPartnersController::class, 'destroy'])->name('internalPartners.destroy');
    
        Route::post('parceiro/externo/adicionar', [ExternalPartnersController::class, 'store'])->name('externalPartners.store');
        Route::post('parceiro/externo/editar/{id}', [ExternalPartnersController::class, 'update'])->name('externalPartners.update');
        Route::delete('parceiro/externo/deletar/{id}', [ExternalPartnersController::class, 'destroy'])->name('externalPartners.destroy');
    
        Route::post('acao/extencao/adicionar', [ExtencionActionsController::class, 'store'])->name('extencionActions.store');
        Route::post('acao/extencao/editar/{id}', [ExtencionActionsController::class, 'update'])->name('extencionActions.update');
        Route::delete('acao/extencao/deletar/{id}', [ExtencionActionsController::class, 'destroy'])->name('extencionActions.destroy');
    
        Route::post('redes/sociais/adicionar', [SocialMediaController::class, 'store'])->name('socialMedia.store');
        Route::post('redes/sociais/editar/{id}', [SocialMediaController::class, 'update'])->name('socialMedia.update');
        Route::delete('redes/sociais/deletar/{id}', [SocialMediaController::class, 'destroy'])->name('socialMedia.destroy');
    
        Route::post('images/adicionar', [ImagesController::class, 'store'])->name('images.store');
        Route::post('images/editar/{id}', [ImagesController::class, 'update'])->name('images.update');
        Route::delete('images/deletar/{id}', [ImagesController::class, 'destroy'])->name('images.destroy');
    });


    Route::get('users/sair', [UsersController::class, 'logout'])->name('logout');
});
