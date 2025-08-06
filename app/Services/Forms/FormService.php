<?php

namespace App\Services\Forms;

use App\Models\Forms\FormsResponse;
use App\Models\Parameters\Projects;
use App\Repositories\Forms\Form\FormRepository;
use Illuminate\Support\Facades\Auth;

class FormService
{

    private $formRepository;

    public function __construct(
        FormRepository $formRepository
    ) {
        $this->formRepository = $formRepository;
    }

    public function storeResponse($request)
    {
        try {
            $form = $this->formRepository->set($request);
            $active_projects = Projects::where('status', 1)->get();
            foreach ($active_projects as $project) {
                FormsResponse::create([
                    'forms_id' => $form->id,
                    'user_id' => $project->coordinator,
                    'project_id' => $project->id,
                ]);
            }
            return redirect()->back()->with("toast_success", "Cadastro de formulário feito com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao fazer cadastro, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function updateResponse($request, $id)
    {
        try {
            $form = $this->formRepository->update($request, $id);

            return redirect()->back()->with("toast_success", "Cadastro de formulário atualizado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao atualizar cadastro, tente novamente em alguns instantes.")->withInput();
        }
    }
}
