<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Models\Forms\Activitys;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function store(Request $request){
        $user = auth()->user();
        $form = Forms::where('status', '1')->first();
        $response = FormsResponse::where(['user_id' => $user->id, 'forms_id' => $form->id])->first();
        
        Activitys::create([
            "response_forms_id" => $response->id,
            "activity" => $request->activity,
            "address" => $request->address
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $activity = Activitys::find($id);

        $activity->activity = $request->activity;
        $activity->address = $request->address;
        $activity->save();

        return redirect()->back();
    }

    public function destroy($id){
        $activity = Activitys::find($id);
        $activity->delete();

        return redirect()->back();
    }
}
