<?php

namespace App\Repositories\Forms\SocialMedia;

use App\Models\Forms\SocialMedia;

class EloquentSocialMediaRepository implements SocialMediaRepository
{
    public function set($request, $response_id)
    {
        $social_media = SocialMedia::create([
            "response_forms_id" => $response_id,
            "name" => $request->name,
            "link" => $request->link,
        ]);

        return $social_media;
    }

    public function update($request, $id){
        $social_media = SocialMedia::find($id);

        $social_media->name = $request->name;
        $social_media->link = $request->link;
        $social_media->save();
        
        return $social_media;
    }

    public function delete($id)
    {
        $social_media = SocialMedia::find($id);
        $social_media->delete();
    }
}
