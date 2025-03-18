<?php

namespace App\Repositories\Forms\InternalPartner;

interface InternalPartnerRepository{
    public function set($request, $response_id);

    public function delete($id);
}