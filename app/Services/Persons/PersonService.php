<?php

namespace App\Services\Persons;

use App\Repositories\Forms\Form\FormRepository;
use App\Repositories\Forms\Response\ResponseRepository;
use App\Repositories\Forms\SocialMedia\SocialMediaRepository;
use App\Repositories\Persons\PersonsRepository;
use App\Repositories\Settings\Roles\RolesRepository;

class PersonService {
    protected $personRepository;
    protected $rolesRepository;

    public function __construct(
        PersonsRepository $personRepository,
        RolesRepository $rolesRepository
    )
    {
        $this->personRepository = $personRepository;
        $this->rolesRepository = $rolesRepository;
    }

    public function storeResponse($request){
        try {            
            $user = auth()->user();

            $person = $this->personRepository->get($user->id);

            if($person){
                $this->personRepository->update($request, $user->id);
                // if($request->coordinator_profile == "Técnico Administrativo"){
                //     $this->rolesRepository->updateUserRole($user, 'Visitante');
                // }
            }
            else{
                $this->personRepository->set($request, $user->id);
                if($request->coordinator_profile == "Docente"){
                    $this->rolesRepository->updateUserRole($user, 'Professor');
                }
            }

            return redirect()->back()->with("toast_success", "Informações adicionadas com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao inserir informações, tente novamente em alguns instantes.")->withInput();
        }
    }
}
