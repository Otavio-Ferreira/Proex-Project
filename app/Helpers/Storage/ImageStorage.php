<?php

namespace App\Helpers\Storage;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageStorage
{
    public static function storage($request, $form_id, $response_id)
    {
        if ($request->hasFile('image')) {
            $path = "imagens/form_{$form_id}/response_{$response_id}/";

            $randomName = Str::random(10) . '.' . $request->file('image')->getClientOriginalExtension();

            $imagePath = $request->file('image')->storeAs($path, $randomName, 'public');

            $imageUrl = Storage::url($imagePath);
        } else {
            $imageUrl = null;
        }
        
        return $imageUrl;
    }

    public static function destroy($image_url)
    {
        $oldImagePath = str_replace('storage/', 'public/', $image_url);

        if (Storage::exists($oldImagePath)) {
            Storage::delete($oldImagePath);

            return true;
        }

        return false;
    }
}
