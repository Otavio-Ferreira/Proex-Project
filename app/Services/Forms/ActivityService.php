<?php

namespace App\Services\Forms;

use App\Models\Forms\FormsResponse;
use App\Repositories\Forms\Activity\ActivityRepository;
use App\Repositories\Forms\Form\FormRepository;
use App\Repositories\Forms\Response\ResponseRepository;

class ActivityService
{

    private $activityRepository;
    private $formRepository;
    private $responseRepository;

    public function __construct(
        ActivityRepository $activityRepository,
        FormRepository $formRepository,
        ResponseRepository $responseRepository
    ) {
        $this->activityRepository = $activityRepository;
        $this->formRepository = $formRepository;
        $this->responseRepository = $responseRepository;
    }

    public function storeResponse($request, $uuid)
    {
        try {
            $response = FormsResponse::find($uuid);
            $this->activityRepository->set($request, $response->id);

            return redirect()->back()->with("toast_success", "Atividade inserida com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao inserir atividade, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function updateResponse($request, $id)
    {
        try {
            $this->activityRepository->update($request, $id);

            return redirect()->back()->with("toast_success", "Atividade inserida com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao atualizar atividade, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function destroyResponse($id)
    {
        try {
            $this->activityRepository->delete($id);

            return redirect()->back()->with("toast_success", "Atividade deletada com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao deletar atividade, tente novamente em alguns instantes.")->withInput();
        }
    }
}
