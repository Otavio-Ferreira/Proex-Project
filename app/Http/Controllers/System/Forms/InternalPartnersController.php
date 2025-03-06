<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Models\Forms\InternalPartners;
use Illuminate\Http\Request;

class InternalPartnersController extends Controller
{
    public function store(Request $request){
        $user = auth()->user();
        $form = Forms::where('status', '1')->first();
        $response = FormsResponse::where(['user_id' => $user->id, 'forms_id' => $form->id])->first();
        
        InternalPartners::create([
            "response_forms_id" => $response->id,
            "title_partner" => $request->title_partner,
        ]);

        return redirect()->back();
    }

    public function destroy($id){
        $internal_partner = InternalPartners::find($id);
        $internal_partner->delete();

        return redirect()->back();
    }
}
