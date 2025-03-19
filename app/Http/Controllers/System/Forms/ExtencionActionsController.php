<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExtencionAction\StoreRequest;
use App\Http\Requests\ExtencionAction\UpdateRequest;
use App\Models\Forms\ExtensionActions;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Services\Forms\ExtensionActionService;
use Illuminate\Http\Request;

class ExtencionActionsController extends Controller
{
    protected $extensionActionService;

    public function __construct(
        ExtensionActionService $extensionActionService
    ) {
        $this->extensionActionService = $extensionActionService;
    }

    public function store(StoreRequest $request){
        return $this->extensionActionService->storeResponse($request);
    }

    public function update(UpdateRequest $request, $id){
        return $this->extensionActionService->updateResponse($request, $id);
    }

    public function destroy($id){
        return $this->extensionActionService->destroyResponse($id);
    }
}
