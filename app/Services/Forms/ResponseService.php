<?php

namespace App\Services\Forms;

use App\Models\Forms\Comments;
use App\Models\Forms\FormsResponse;
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

    public function persistResponse($request, $uuid)
    {
        try {
            $response = FormsResponse::find($uuid);
            $user = auth()->user();

            if ($response) {
                $this->responseRepository->update($response, $request);
            } else {
                $this->responseRepository->set($request, $response->forms_id, $user->id);
            }

            return to_route('response.start', $uuid)->with("toast_success", "Seção do formulário enviada.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao preencher seção do cadastro, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function updateResponse($request, $id){
        try {
            $form_response = FormsResponse::find($id);
            $form_response->was_finished = $request->status;
            $form_response->save();

            if($request->has('comment')){
                $comment = Comments::where('form_response_id', $form_response->id)->first();

                if($comment){
                    $comment->comment = $request->comment;
                    $comment->save();
                }
                else{
                    Comments::create([
                        "form_response_id" => $form_response->id,
                        "comment" => $request->comment
                    ]);
                }
            }

            return redirect()->back()->with("toast_success", "Avaliação enviada com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao fazer avaliação, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function finishResponse($uuid)
    {
        try {
            $response = FormsResponse::find($uuid);
            $this->responseRepository->finish($response);

            return redirect()->back()->with("toast_success", "Formulário finalizado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao finalizar formulário, tente novamente em alguns instantes.")->withInput();
        }
    }
}