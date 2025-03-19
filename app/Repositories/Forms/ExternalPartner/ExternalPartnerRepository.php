<?php

namespace App\Repositories\Forms\ExternalPartner;

interface ExternalPartnerRepository{
    public function set($request, $response_id);

    public function update($request, $id);
    
    public function delete($id);

}