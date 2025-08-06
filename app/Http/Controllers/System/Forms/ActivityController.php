<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\StoreRequest;
use App\Http\Requests\Activity\UpdateRequest;
use App\Services\Forms\ActivityService;

class ActivityController extends Controller
{
    private $activityService;

    public function __construct(
        ActivityService $activityService
    )
    {
        $this->activityService = $activityService;
    }
    public function store(StoreRequest $request, $uuid){
        return $this->activityService->storeResponse($request, $uuid);
    }
    
    public function update(UpdateRequest $request, $id){
        return $this->activityService->updateResponse($request, $id);
    }
    
    public function destroy($id){
        return $this->activityService->destroyResponse($id);
    }
}
