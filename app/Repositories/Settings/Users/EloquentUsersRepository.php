<?php

namespace App\Repositories\Settings\Users;

use App\Http\Requests\Users\StoreRequest;
use App\Models\Persons\Persons;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EloquentUsersRepository implements UsersRepository
{
    public function getAllPaginate($request = null)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereHas('persons', function ($coordinatorQuery) use ($search) {
                        $coordinatorQuery->where('coordinator_siape', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('persons', function ($coordinatorQuery) use ($search) {
                        $coordinatorQuery->where('coordinator_course', 'like', '%' . $search . '%');
                    });
            });
        }

        return $query->orderBy('name', 'asc')->paginate(20);
    }

    public function set($request) : User
    {
        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "status" => 0,
                "active_role" => $request->role[0]
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
            "status" => 2,
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
