<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\StoreRequest;
use App\Http\Requests\Image\UpdateRequest;
use App\Services\Forms\ImageService;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    protected $imageService;

    public function __construct(
        ImageService $imageService
    ) {
        $this->imageService = $imageService;
    }
    
    public function store(StoreRequest $request)
    {
        return $this->imageService->storeResponse($request);
    }

    public function update(UpdateRequest $request, $id)
    {
        return $this->imageService->updateResponse($request, $id);
    }

    public function destroy($id)
    {
        return $this->imageService->destroyResponse($id);
    }
}
