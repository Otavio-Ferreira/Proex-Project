<?php

namespace App\Repositories\Forms\SocialMedia;

interface SocialMediaRepository{
    
    public function set($request, $response_id);

    public function update($request, $id);
    
    public function delete($id);
}