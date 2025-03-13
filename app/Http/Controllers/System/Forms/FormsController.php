<?php

namespace App\Http\Controllers\System\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\StoreRequest;
use App\Repositories\Forms\Form\FormRepository;
use App\Services\Forms\FormService;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    private $data = [];
    private $formService;
    private $formRepository;

    public function __construct(
        FormService $formService,
        FormRepository $formRepository
    )
    {
        $this->formService = $formService;
        $this->formRepository = $formRepository;
    }

    public function create(Request $request)
    {
        $this->data['forms'] = $this->formRepository->getAllForm($request);
        return view('pages.forms.create', $this->data);
    }

    public function store(StoreRequest $request)
    {
        return $this->formService->storeResponse($request);
    }

    public function update(Request $request, $id)
    {
        return $this->formService->updateResponse($request, $id);
    }
}
