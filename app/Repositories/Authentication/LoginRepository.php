<?php 

namespace App\Repositories\Authentication;

use App\Http\Requests\Authentication\ResetRequest;
use App\Models\Authentication\Tokens;
use App\Models\User;

interface LoginRepository{
    public function createToken(User $request, $type);

    public function changePassword(ResetRequest $request, Tokens $token);
}