<?php

namespace App\Repositories\Forms\ExtensionAction;

interface ExtensionActionRepository{
    public function set($request, $response_id);

    public function update($request, $id);
    
    public function delete($id);
}