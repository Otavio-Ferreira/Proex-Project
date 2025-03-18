<?php

namespace App\Services\Forms;

use App\Helpers\Storage\ImageStorage;
use App\Repositories\Forms\Form\FormRepository;
use App\Repositories\Forms\Image\ImageRepository;
use App\Repositories\Forms\Response\ResponseRepository;

class ImageService
{
    protected $imageRepository;
    protected $formRepository;
    protected $responseRepository;

    public function __construct(
        ImageRepository $imageRepository,
        FormRepository $formRepository,
        ResponseRepository $responseRepository
    ) {
        $this->imageRepository = $imageRepository;
        $this->formRepository = $formRepository;
        $this->responseRepository = $responseRepository;
    }

    public function storeResponse($request)
    {
        try {
            $user = auth()->user();
            $form = $this->formRepository->getActualForm();
            $response = $this->responseRepository->getUserFormResponse($user->id, $form->id);
            
            $image_url = ImageStorage::storage($request, $form->id, $response->id);
            $this->imageRepository->set($request, $response->id, $image_url);

            return redirect()->back()->with("toast_success", "Imagem inserida com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao inserir imagem, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function updateResponse($request, $id)
    {
        try {
            $actual_image = $this->imageRepository->getOne($id);

            $user = auth()->user();
            $form = $this->formRepository->getActualForm();
            $response = $this->responseRepository->getUserFormResponse($user->id, $form->id);
            
            if ($request->hasFile('image')) {
                ImageStorage::destroy($actual_image->image);
                $image_url = ImageStorage::storage($request, $form->id, $response->id);
            }
            else{
                $image_url = $actual_image->image;
            }


            $this->imageRepository->update($request, $id, $image_url);

            return redirect()->back()->with("toast_success", "Imagem atualizada com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao atualizar imagem, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function destroyResponse($id)
    {
        try {
            $actual_image = $this->imageRepository->getOne($id);
            ImageStorage::destroy($actual_image->image);
            $this->imageRepository->delete($id);

            return redirect()->back()->with("toast_success", "Imagem deletada com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao deletar imagem, tente novamente em alguns instantes.")->withInput();
        }
    }
}
