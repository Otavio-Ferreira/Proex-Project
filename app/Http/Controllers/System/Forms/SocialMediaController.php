<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Models\Forms\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function store(Request $request){
        $user = auth()->user();
        $form = Forms::where('status', '1')->first();
        $response = FormsResponse::where(['user_id' => $user->id, 'forms_id' => $form->id])->first();
        
        SocialMedia::create([
            "response_forms_id" => $response->id,
            "name" => $request->name,
            "link" => $request->link,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $social_media = SocialMedia::find($id);

        $social_media->name = $request->name;
        $social_media->link = $request->link;
        $social_media->save();

        return redirect()->back();
    }

    public function destroy($id){
        $social_media = SocialMedia::find($id);
        $social_media->delete();

        return redirect()->back();
    }
}
