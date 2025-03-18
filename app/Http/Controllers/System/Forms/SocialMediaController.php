<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialMedia\StoreRequest;
use App\Http\Requests\SocialMedia\UpdateRequest;
use App\Services\Forms\SocialMediaService;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    protected $socialMediaService;

    public function __construct(
        SocialMediaService $socialMediaService
    ) {
        $this->socialMediaService = $socialMediaService;
    }
    public function store(StoreRequest $request)
    {
        return $this->socialMediaService->storeResponse($request);
    }
    public function update(UpdateRequest $request, $id)
    {
        return $this->socialMediaService->updateResponse($request, $id);
    }
    public function destroy($id)
    {
        return $this->socialMediaService->destroyResponse($id);
    }
}
