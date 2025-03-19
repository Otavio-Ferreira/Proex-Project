<?php

namespace App\Repositories\Forms\Activity;


interface ActivityRepository{
    public function set($request, $response_forms_id);
    
    public function update($request, $id);
 
    public function delete($id);

}