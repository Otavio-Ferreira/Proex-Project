<?php

namespace App\Repositories\Settings\Users;

use App\Models\User;

interface UsersRepository{
    public function getAllPaginate($request = null);
    
    public function set($request) : User;

    public function delete($id) : void;

    public function getByEmail($email);

    public function setForce($name, $siape, $email, $course);
}