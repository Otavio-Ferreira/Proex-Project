<?php

namespace App\Services\Forms;

use App\Models\Forms\FormsResponse;
use App\Repositories\Forms\InternalPartner\InternalPartnerRepository;
use App\Repositories\Forms\Form\FormRepository;
use App\Repositories\Forms\Response\ResponseRepository;

class InternalPartnerService {
    private $internalPartnerRepository;
    private $formRepository;
    private $responseRepository;

    public function __construct(
        InternalPartnerRepository $internalPartnerRepository,
        FormRepository $formRepository,
        ResponseRepository $responseRepository
    )
    {
        $this->internalPartnerRepository = $internalPartnerRepository;
        $this->formRepository = $formRepository;
        $this->responseRepository = $responseRepository;
    }

    public function storeResponse($request, $uuid){
        try {            
            $user = auth()->user();
            $response = FormsResponse::find($uuid);
            $this->internalPartnerRepository->set($request, $response->id);

            return redirect()->back()->with("toast_success", "Parceria interna inserida com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao inserir parceria interna, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function destroyResponse($id){
        try {            
            $this->internalPartnerRepository->delete($id);
        
            return redirect()->back()->with("toast_success", "Parceria interna deletada com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao deletar parceria interna, tente novamente em alguns instantes.")->withInput();
        }
    }
}
