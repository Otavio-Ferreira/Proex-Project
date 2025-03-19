<?php

namespace App\Services\Forms;

use App\Repositories\Forms\ExtensionAction\ExtensionActionRepository;
use App\Repositories\Forms\Form\FormRepository;
use App\Repositories\Forms\Response\ResponseRepository;

class ExtensionActionService {
    protected $extensionActionRepository;
    protected $formRepository;
    protected $responseRepository;

    public function __construct(
        ExtensionActionRepository $extensionActionRepository,
        FormRepository $formRepository,
        ResponseRepository $responseRepository
    )
    {
        $this->extensionActionRepository = $extensionActionRepository;
        $this->formRepository = $formRepository;
        $this->responseRepository = $responseRepository;
    }

    public function storeResponse($request){
        try {            
            $user = auth()->user();
            $form = $this->formRepository->getActualForm();
            $response = $this->responseRepository->getUserFormResponse($user->id, $form->id);
            $this->extensionActionRepository->set($request, $response->id);

            return redirect()->back()->with("toast_success", "Ação inserida com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao inserir ação, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function updateResponse($request, $id){
        try {            
            $this->extensionActionRepository->update($request, $id);
        
            return redirect()->back()->with("toast_success", "Ação atualizada com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao atualizar ação, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function destroyResponse($id){
        try {            
            $this->extensionActionRepository->delete($id);
        
            return redirect()->back()->with("toast_success", "Ação deletada com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao deletar ação, tente novamente em alguns instantes.")->withInput();
        }
    }
}
