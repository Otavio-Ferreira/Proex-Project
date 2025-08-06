<?php 

namespace App\Repositories\Settings\Roles;

use App\Http\Requests\Spatie\RoleRequest;
use App\Http\Requests\Users\StoreRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

interface RolesRepository{
    public function set(User $user, $request) :void;

    public function create(RoleRequest $request) : void;

    public function update(RoleRequest $request, $id) : void;
    
    public function updateUserRole($user, $role) : void;
}