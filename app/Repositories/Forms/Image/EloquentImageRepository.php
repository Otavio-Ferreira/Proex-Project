<?php

namespace App\Repositories\Forms\Image;

use App\Models\Forms\Images;

class EloquentImageRepository implements ImageRepository
{

    public function getOne($id){
        return Images::find($id);
    }

    public function set($request, $response_id, $image_url)
    {
        $image = Images::create([
            "response_forms_id" => $response_id,
            "image" => $image_url,
            "address" => $request->address,
            "date" => $request->date,
            "description" => $request->description,
        ]);

        return $image;
    }

    public function update($request, $id, $image_url)
    {
        $image = Images::findOrFail($id);

        $image->address = $request->address;
        $image->date = $request->date;
        $image->description = $request->description;
        $image->image = $image_url;
        $image->save();

        return $image;
    }

    public function delete($id)
    {
        $image = Images::findOrFail($id);
        $image->delete();
    }
}
