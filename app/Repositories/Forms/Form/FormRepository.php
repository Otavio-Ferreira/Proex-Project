<?php

namespace App\Repositories\Forms\Form;

use App\Models\User;

interface FormRepository{

    public function getAllForm($request);

    public function getActualForm();

    public function set($request);

    public function update($request, $id);
}