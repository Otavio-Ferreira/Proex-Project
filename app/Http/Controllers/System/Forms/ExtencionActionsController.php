<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Models\Forms\ExtensionActions;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use Illuminate\Http\Request;

class ExtencionActionsController extends Controller
{
    public function store(Request $request){
        $user = auth()->user();
        $form = Forms::where('status', '1')->first();
        $response = FormsResponse::where(['user_id' => $user->id, 'forms_id' => $form->id])->first();
        
        ExtensionActions::create([
            "response_forms_id" => $response->id,
            "title_action" => $request->title_action,
            "its_for_public_schools" => $request->its_for_public_schools,
            "international_description" => $request->international_description,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id){
        // dd($request->all());
        $extencion_action = ExtensionActions::find($id);

        $extencion_action->title_action = $request->title_action;
        $extencion_action->its_for_public_schools = $request->its_for_public_schools;
        $extencion_action->international_description = $request->international_description;
        $extencion_action->save();

        return redirect()->back();
    }

    public function destroy($id){
        $extencion_action = ExtensionActions::find($id);
        $extencion_action->delete();

        return redirect()->back();
    }
}
