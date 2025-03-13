<?php

namespace App\Services\Forms;

use App\Repositories\Forms\Form\FormRepository;
use App\Repositories\Forms\Response\ResponseRepository;

class ResponseService
{

    private $responseRepository;
    private $formRepository;

    public function __construct(
        ResponseRepository $responseRepository,
        FormRepository $formRepository
    ) {
        $this->responseRepository = $responseRepository;
        $this->formRepository = $formRepository;
    }

    public function persistResponse($request)
    {
        try {
            $actual_form = $this->formRepository->getActualForm();
            $user = auth()->user();
            $form_response = $this->responseRepository->getUserFormResponse($user->id, $actual_form->id);

            if ($form_response) {
                $this->responseRepository->update($form_response, $request);
            } else {
                $this->responseRepository->set($request, $actual_form->id, $user->id);
                session()->put('step', 2);
            }

            return redirect()->back()->with("toast_success", "Seção do formulário enviada.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao preencher seção do cadastro, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function finishResponse()
    {
        try {
            $actual_form = $this->formRepository->getActualForm();
            $user = auth()->user();
            $form_response = $this->responseRepository->getUserFormResponse($user->id, $actual_form->id);
            $this->responseRepository->finish($form_response);

            return redirect()->back()->with("toast_success", "Formulário finalizado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao finalizar formulário, tente novamente em alguns instantes.")->withInput();
        }
    }
}