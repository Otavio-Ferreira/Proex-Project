<?php

namespace App\Services\Forms;

use App\Repositories\Forms\Form\FormRepository;

class FormService {

    private $formRepository;

    public function __construct(
        FormRepository $formRepository
    )
    {
        $this->formRepository = $formRepository;
    }

    public function storeResponse($request)
    {
        try {            
            $this->formRepository->set($request);

            return redirect()->back()->with("toast_success", "Cadastro de formulário feito com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao fazer cadastro, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function updateResponse($request, $id)
    {
        try {
            $this->formRepository->update($request, $id);

            return redirect()->back()->with("toast_success", "Cadastro de formulário atualizado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao atualizar cadastro, tente novamente em alguns instantes.")->withInput();
        }
    }
}
