<?php

namespace App\Services\Forms;

use App\Repositories\Forms\ExternalPartner\ExternalPartnerRepository;
use App\Repositories\Forms\Form\FormRepository;
use App\Repositories\Forms\Response\ResponseRepository;

class ExternalPartnerService {
    private $externalPartnerRepository;
    private $formRepository;
    private $responseRepository;

    public function __construct(
        ExternalPartnerRepository $externalPartnerRepository,
        FormRepository $formRepository,
        ResponseRepository $responseRepository
    )
    {
        $this->externalPartnerRepository = $externalPartnerRepository;
        $this->formRepository = $formRepository;
        $this->responseRepository = $responseRepository;
    }

    public function storeResponse($request){
        try {            
            $user = auth()->user();
            $form = $this->formRepository->getActualForm();
            $response = $this->responseRepository->getUserFormResponse($user->id, $form->id);
            $this->externalPartnerRepository->set($request, $response->id);

            return redirect()->back()->with("toast_success", "Parceiro externo inserida com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao inserir parceiro externo, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function updateResponse($request, $id){
        try {            
            $this->externalPartnerRepository->update($request, $id);
        
            return redirect()->back()->with("toast_success", "Parceiro externo atualizada com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao atualizar parceiro externo, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function destroyResponse($id){
        try {            
            $this->externalPartnerRepository->delete($id);
        
            return redirect()->back()->with("toast_success", "Parceiro externo deletada com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao deletar parceiro externo, tente novamente em alguns instantes.")->withInput();
        }
    }
}
