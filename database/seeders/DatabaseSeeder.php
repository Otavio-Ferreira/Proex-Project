<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Forms\Activitys;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Models\Parameters\Courses;
use App\Models\Parameters\Projects;
use App\Models\Persons\Persons;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //////////////////////
        ///// Permissões /////
        //////////////////////

        $permissions = [
            "1" => "adicionar_grupo",
            "2" => "adicionar_usuário",
            "3" => "ver_dashboard",
            "4" => "adicionar_cursos",
            "5" => "adicionar_projetos",
            "6" => "responder_formulário",
            "7" => "adicionar_formulário",
            "8" => "ver_respostas",
            "9" => "ver_seus_projetos"
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        ////////////////////////////
        ///// Grupos e Portais /////
        ////////////////////////////

        $roles = [
            [
                "role" => "Desenvolvimento",
                "description" => "O portal do desenvolvimento é destinado aos desenvolvedores do sistema.",
                "permissions" => [
                    "adicionar_grupo",
                    "adicionar_usuário",
                    "ver_dashboard",
                    "adicionar_cursos",
                    "adicionar_projetos",
                    "responder_formulário",
                    "ver_respostas",
                    "ver_seus_projetos",
                    "adicionar_formulário",
                ]
            ],
            [
                "role" => "Administrador",
                "description" => "O portal do administrador é destinado aos Administradores do sistema.",
                "permissions" => [
                    "adicionar_usuário",
                    "ver_dashboard",
                    "adicionar_cursos",
                    "adicionar_projetos",
                    "responder_formulário",
                    "ver_respostas",
                    "ver_seus_projetos",
                    "adicionar_formulário",
                ]
            ],
            [
                "role" => "Coordenador",
                "description" => "O portal do coordenador é destinado aos coordenadores de trabalhos.",
                "permissions" => [
                    "ver_seus_projetos",
                    "responder_formulário",
                ]
            ],
            [
                "role" => "Visitante",
                "description" => "O portal do visitante é destinado aos visitantes do sistema.",
                "permissions" => []
            ],
        ];

        foreach ($roles as $key => $role) {
            $role_portal = Role::create([
                'name' => $role['role'],
                'guard_name' => 'web',
                'description' => $role['description'],
            ]);

            foreach ($role as $value) {
                $role_portal->givePermissionTo($roles[$key]['permissions']);
            }
        }

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'status' => 1,
            'active_role' => "Desenvolvimento"
        ]);

        Persons::create([
            "user_id" => $user->id,
            "coordinator_name" => $user->name,
            "coordinator_profile" => "Desenvolvedor",
            "coordinator_siape" => null,
            "coordinator_course" => null
        ]);

        $user->assignRole('Desenvolvimento');

        $this->call([
            ParameterSeeder::class
        ]);
    }
}
