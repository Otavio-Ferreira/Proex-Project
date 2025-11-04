<?php

namespace App\Repositories\Forms\Activity;

use App\Http\Requests\Users\StoreRequest;
use App\Models\Forms\Activitys;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EloquentActivityRepository implements ActivityRepository
{
    public function set($request, $response_forms_id)
    {
        Activitys::create([
            "response_forms_id" => $response_forms_id,
            "activity" => $request->activity,
            "address" => $request->addressChose ? $request->addressChose : $request->address,
            "latitude" => $request->latitude, 
            "longitude" => $request->longitude, 
            "place_id" => $request->place_id
        ]);
    }

    public function update($request, $id){
        $activity = Activitys::find($id);
        
        $activity->activity = $request->activity;
        $activity->address = $request->address;
        $activity->save();
    }

    public function delete($id) : void
    {
        $activity = Activitys::find($id);
        $activity->delete();
    }
}
