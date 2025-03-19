<?php

namespace App\Repositories\Forms\Image;

interface ImageRepository{

    public function getOne($id);
    
    public function set($request, $response_id, $image_url);
    
    public function update($request, $image_url, $url);

    public function delete($id);

}