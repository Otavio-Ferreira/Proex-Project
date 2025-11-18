<?php

namespace App\Services\Persons;

use App\Models\User;
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
            $userActive = User::find($user->id);

            $person = $this->personRepository->get($user->id);

            if($person){
                $this->personRepository->update($request, $user->id);
                // if($request->coordinator_profile == "Docente" && $person->coordinator_profile == null){
                //     $this->rolesRepository->updateUserRole($user, 'Coordenador');
                    
                //     $userActive->active_role = 'Coordenador';
                //     $userActive->save();
                // }
            }
            else{
                $this->personRepository->set($request, $user->id);
                // if($request->coordinator_profile == "Docente"){
                //     $this->rolesRepository->updateUserRole($user, 'Coordenador');
                //     $userActive->active_role = 'Coordenador';
                //     $userActive->save();
                // }
            }

            return redirect()->back()->with("toast_success", "Informações adicionadas com sucesso.");
        } catch (\Throwable $th) {
            return redirect()->back()->with("toast_error", "Erro ao inserir informações, tente novamente em alguns instantes.")->withInput();
        }
    }
}
