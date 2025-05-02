<?php

namespace App\Services\Courses;

use App\Repositories\Course\CourseRepository;

class CourseService
{
    protected $courseRepository;

    public function __construct(
        CourseRepository $courseRepository
    ) {
        $this->courseRepository = $courseRepository;
    }

    public function storeResponse($request)
    {
        try {

            $course = $this->courseRepository->set($request); 

            if(!$course){
                return redirect()->back()->with("toast_error", "Erro ao inserir curso, tente novamente em alguns instantes.")->withInput();
            }

            return redirect()->back()->with("toast_success", "Curso adicionado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao inserir curso, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function updateResponse($request, $id)
    {
        try {

            $this->courseRepository->update($request, $id);

            return redirect()->back()->with("toast_success", "Curso atualizado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao atualizar curso, tente novamente em alguns instantes.")->withInput();
        }
    }

    public function destroyResponse($id)
    {
        try {

            $this->courseRepository->delete($id);

            return redirect()->back()->with("toast_success", "Curso deletado com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao deletar curso, tente novamente em alguns instantes.")->withInput();
        }
    }
}
