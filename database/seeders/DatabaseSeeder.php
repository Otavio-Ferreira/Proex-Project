<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $user = User::factory()->create([
            'name' => 'Otavio Ferreira',
            'email' => 'admin@gmail.com',
            'status' => 1,
        ]);

        $permissions = [
            "1" => "adicionar_grupo",
            "2" => "adicionar_usuário",
            "3" => "ver_dashboard",
            "4" => "adicionar_cursos",
            "5" => "adicionar_projetos",
            "6" => "ver_formulários",
            "7" => "ver_respostas",
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        $role = Role::create([
            'name' => 'Gerente',
            'guard_name' => 'web'
        ]);

        $role->givePermissionTo([
            "adicionar_grupo",
            "adicionar_usuário",
            "ver_dashboard",
            "adicionar_cursos",
            "adicionar_projetos",
            "ver_formulários",
            "ver_respostas",
        ]);

        $user->assignRole($role);
    }
}
