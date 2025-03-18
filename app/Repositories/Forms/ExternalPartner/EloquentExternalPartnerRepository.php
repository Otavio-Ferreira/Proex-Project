<?php

namespace App\Repositories\Forms\ExternalPartner;

use App\Models\Forms\ExternalPartners;

class EloquentExternalPartnerRepository implements ExternalPartnerRepository
{
    public function set($request, $response_id)
    {
        $external_partner = ExternalPartners::create([
            "response_forms_id" => $response_id,
            "name_partner" => $request->name_partner,
            "institution_type" => $request->institution_type,
            "partnership_type" => $request->partnership_type,
        ]);

        return $external_partner;
    }

    public function update($request, $id){
        $external_partner = ExternalPartners::find($id);

        $external_partner->name_partner = $request->name_partner;
        $external_partner->institution_type = $request->institution_type;
        $external_partner->partnership_type = $request->partnership_type;
        $external_partner->save();
        
        return $external_partner;
    }

    public function delete($id)
    {
        $external_partner = ExternalPartners::find($id);
        $external_partner->delete();
    }

}
