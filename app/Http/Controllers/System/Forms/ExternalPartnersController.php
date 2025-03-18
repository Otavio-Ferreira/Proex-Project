<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExternalPartner\StoreRequest;
use App\Http\Requests\ExternalPartner\UpdateRequest;
use App\Services\Forms\ExternalPartnerService;
use Illuminate\Http\Request;

class ExternalPartnersController extends Controller
{
    protected $externalPartnerService;

    public function __construct(
        ExternalPartnerService $externalPartnerService
    ) {
        $this->externalPartnerService = $externalPartnerService;
    }

    public function store(StoreRequest $request){
        return $this->externalPartnerService->storeResponse($request);
    }

    public function update(UpdateRequest $request, $id){
        return $this->externalPartnerService->updateResponse($request, $id);
    }

    public function destroy($id){
        return $this->externalPartnerService->destroyResponse($id);
    }
}
