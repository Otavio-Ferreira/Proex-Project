<?php

namespace App\Repositories\Forms\Response;

use App\Models\User;

interface ResponseRepository{

    
    public function getUserFormResponse($user_id, $forms_id);
    
    public function update($form_response, $request);

    public function set($reques, $form_id, $user_idt);

    public function finish($form_response);

}