<?php

namespace App\Repositories\Settings\Users;

use App\Models\User;

interface UsersRepository{
    public function set($request) : User;

    public function delete($id) : void;

    // public function setUser($request, $password);
}