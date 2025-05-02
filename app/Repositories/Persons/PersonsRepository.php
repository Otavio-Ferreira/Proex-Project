<?php

namespace App\Repositories\Persons;

use App\Models\User;

interface PersonsRepository{
    public function set($request, $id);

    public function get($id);

    public function update($request, $id);
}