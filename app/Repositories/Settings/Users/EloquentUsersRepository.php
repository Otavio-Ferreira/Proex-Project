<?php

namespace App\Repositories\Settings\Users;

use App\Http\Requests\Users\StoreRequest;
use App\Models\Persons\Persons;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EloquentUsersRepository implements UsersRepository
{
    public function set($request) : User
    {
        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "status" => 0,
            ]);
            return $user;
        });

        return $user;
    }

    public function delete($id) : void
    {
        DB::transaction(function () use ($id) {
            $register = User::find($id);
            $register->delete();
        });
    }

    public function setForce($name, $siape, $email, $course){
        $user = User::create([
            "name" => $name,
            "email" => $email,
            "status" => 1,
            "password" => null
        ]);

        Persons::create([
            "user_id" => $user->id,
            "coordinator_name" => $user->name,
            "coordinator_profile" => null,
            "coordinator_siape" => $siape,
            "coordinator_course" => $course
        ]);
        
        return $user;
    }
}
