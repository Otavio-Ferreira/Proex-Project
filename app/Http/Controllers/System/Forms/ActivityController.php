<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Models\Forms\Activitys;
use App\Models\Forms\Forms;
use App\Models\Forms\FormsResponse;
use App\Services\Forms\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    private $activityService;

    public function __construct(
        ActivityService $activityService
    )
    {
        $this->activityService = $activityService;
    }
    public function store(Request $request){
        return $this->activityService->storeResponse($request);
    }
    
    public function update(Request $request, $id){
        return $this->activityService->updateResponse($request, $id);
    }
    
    public function destroy($id){
        return $this->activityService->destroyResponse($id);
    }
}
