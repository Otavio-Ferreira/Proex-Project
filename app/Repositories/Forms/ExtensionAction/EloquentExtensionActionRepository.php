<?php

namespace App\Repositories\Forms\ExtensionAction;

use App\Models\Forms\ExtensionActions;

class EloquentExtensionActionRepository implements ExtensionActionRepository
{
    public function set($request, $response_id)
    {
        $extencion_action = ExtensionActions::create([
            "response_forms_id" => $response_id,
            "title_action" => $request->title_action,
            "its_for_public_schools" => $request->its_for_public_schools,
            "international_description" => $request->international_description,
        ]);

        return $extencion_action;
    }

    public function update($request, $id){
        $extencion_action = ExtensionActions::find($id);

        $extencion_action->title_action = $request->title_action;
        $extencion_action->its_for_public_schools = $request->its_for_public_schools;
        $extencion_action->international_description = $request->international_description;
        $extencion_action->save();
        
        return $extencion_action;
    }

    public function delete($id)
    {
        $extencion_action = ExtensionActions::find($id);
        $extencion_action->delete();
    }
}
