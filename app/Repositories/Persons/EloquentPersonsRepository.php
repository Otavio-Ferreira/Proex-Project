<?php

namespace App\Repositories\Persons;

use App\Models\Persons\Persons;
use App\Models\User;

class EloquentPersonsRepository implements PersonsRepository
{
    public function set($request, $id)
    {
        $person= Persons::create([
            "user_id" => $id, 
            "coordinator_name" => $request->coordinator_name ?? null,
            "coordinator_profile" => $request->coordinator_profile ?? null,
            "coordinator_siape" => $request->coordinator_siape ?? null,
            "coordinator_course" => $request->coordinator_course ?? null,
        ]);

        $user = User::find($id);
        $user->name = $request->coordinator_name ?? $user->name;
        $user->save();

        return $person;
    }

    public function get($id)
    {
        return Persons::where('user_id', $id)->first();
    }

    public function update($request, $id)
    {
        $person = Persons::where('user_id', $id)->first();

        if($person){
            $person->coordinator_name = $request->coordinator_name ?? $person->coordinator_name; 
            $person->coordinator_profile = $request->coordinator_profile ?? $person->coordinator_profile; 
            $person->coordinator_siape = $request->coordinator_siape ?? $person->coordinator_siape; 
            $person->coordinator_course = $request->coordinator_course ?? $person->coordinator_course; 
            $person->save();
        }

        $user = User::find($id);
        $user->name = $request->coordinator_name ?? $user->name;
        $user->save();

        return $person;
    }
}