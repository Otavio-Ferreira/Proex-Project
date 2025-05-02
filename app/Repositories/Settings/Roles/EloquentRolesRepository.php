<?php

namespace App\Repositories\Settings\Roles;

use App\Http\Requests\Spatie\RoleRequest;
use App\Http\Requests\Users\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class EloquentRolesRepository implements RolesRepository{
    public function set(User $user, $request) : void
    {
        DB::transaction(function () use ($user, $request) {
            $user->assignRole($request->role);
        });
    }

    public function create(RoleRequest $request) : void
    {
        DB::transaction(function () use ($request) {
            $role = Role::create([
                'name' => $request->name
            ]);
            $role->givePermissionTo([$request->permission_selected]);

        });
    }

    public function update(RoleRequest $request, $id) : void
    {
        DB::transaction(function () use ($request, $id) {
            $role = Role::findOrFail($id);
            $role->name = $request->name;
            $role->save();
            $selectedPermissions = $request->input('permission_selected', []);
            $role->syncPermissions($selectedPermissions);

        });
    }

    public function updateUserRole($user, $role) : void
    {
        $user->syncRoles($role);
    }
}