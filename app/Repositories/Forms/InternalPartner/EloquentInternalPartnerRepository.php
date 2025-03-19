<?php

namespace App\Repositories\Forms\InternalPartner;

use App\Models\Forms\InternalPartners;
use App\Repositories\Forms\InternalPartner\InternalPartnerRepository;

class EloquentInternalPartnerRepository implements InternalPartnerRepository
{
    public function set($request, $response_id){
        
        $internal_partner = InternalPartners::create([
            "response_forms_id" => $response_id,
            "title_partner" => $request->title_partner,
        ]);

        return $internal_partner;
    }

    public function delete($id){
        $internal_partner = InternalPartners::find($id);
        $internal_partner->delete();
    }
}
