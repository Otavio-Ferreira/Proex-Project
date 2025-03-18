<?php

namespace App\Services\Forms;

use App\Repositories\Forms\Form\FormRepository;
use App\Repositories\Forms\Response\ResponseRepository;
use App\Repositories\Forms\SocialMedia\SocialMediaRepository;

class SocialMediaService {
    protected $socialMediaRepository;
    protected $formRepository;
    protected $responseRepository;

    public function __construct(
        SocialMediaRepository $socialMediaRepository,
        FormRepository $formRepository,
        ResponseRepository $responseRepository
    )
    {
        $this->socialMediaRepository = $socialMediaRepository;
        $this->formRepository = $formRepository;
        $this->responseRepository = $responseRepository;
    }

    public function storeResponse($request){
        try {            
            $user = auth()->user();
            $form = $this->formRepository->getActualForm();
            $response = $this->responseRepository->getUserFormResponse($user->id, $form->id);
            $this->socialMediaRepository->set($request, $response->id);

            return redirect()->back()->with("toast_success", "Rede social inserida com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao inserir rede social, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function updateResponse($request, $id){
        try {            
            $this->socialMediaRepository->update($request, $id);
        
            return redirect()->back()->with("toast_success", "Rede social atualizada com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao atualizar rede social, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function destroyResponse($id){
        try {            
            $this->socialMediaRepository->delete($id);
        
            return redirect()->back()->with("toast_success", "Rede social deletada com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao deletar rede social, tente novamente em alguns instantes.")->withInput();
        }
    }
}
