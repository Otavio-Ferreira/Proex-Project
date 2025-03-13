<?php

namespace App\Repositories\Settings\Users;

use App\Http\Requests\Users\StoreRequest;
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

    // public function setUser($request, $password){
    //     $user = User::create([
    //         "name" => $request->name,
    //         "email" => $request->email,
    //         "status" => 1,
    //         "password" => Hash::make($password)
    //     ]);
    //     return $user;
    // }
}
