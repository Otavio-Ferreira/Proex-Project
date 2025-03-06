<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Models\Forms\ExternalPartners;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use Illuminate\Http\Request;

class ExternalPartnersController extends Controller
{
    public function store(Request $request){
        $user = auth()->user();
        $form = Forms::where('status', '1')->first();
        $response = FormsResponse::where(['user_id' => $user->id, 'forms_id' => $form->id])->first();
        
        ExternalPartners::create([
            "response_forms_id" => $response->id,
            "name_partner" => $request->name_partner,
            "institution_type" => $request->institution_type,
            "partnership_type" => $request->partnership_type,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $external_partner = ExternalPartners::find($id);

        $external_partner->name_partner = $request->name_partner;
        $external_partner->institution_type = $request->institution_type;
        $external_partner->partnership_type = $request->partnership_type;
        $external_partner->save();

        return redirect()->back();
    }

    public function destroy($id){
        $external_partner = ExternalPartners::find($id);
        $external_partner->delete();

        return redirect()->back();
    }
}
