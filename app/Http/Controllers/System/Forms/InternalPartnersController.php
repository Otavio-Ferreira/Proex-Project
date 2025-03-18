<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\InternalPartner\StoreRequest;
use App\Services\Forms\InternalPartnerService;
use Illuminate\Http\Request;

class InternalPartnersController extends Controller
{

    protected $internalPartnerService;

    public function __construct(
        InternalPartnerService $internalPartnerService
    ) {
        $this->internalPartnerService = $internalPartnerService;
    }
    public function store(StoreRequest $request)
    {
        return $this->internalPartnerService->storeResponse($request);
    }

    public function destroy($id)
    {
        return $this->internalPartnerService->destroyResponse($id);
    }
}
