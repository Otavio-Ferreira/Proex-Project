<?php

namespace App\Repositories\Authentication;

use App\Http\Requests\Authentication\ResetRequest;
use App\Models\Authentication\Tokens;
use App\Models\User;
use App\Repositories\Authentication\LoginRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EloquentLoginRepository implements LoginRepository
{
    public function createToken(User $user, $type)
    {
        return DB::transaction(function () use ($user, $type) {

            $token = Tokens::create([
                "user_id" => $user->id,
                "type" => $type,
                "status" => 1,
            ]);

            $data = [
                "token" => $token->id,
                "name" => $user->name,
                "email" => $user->email,
                "time" => Carbon::now('America/Sao_paulo')->format('d/m/Y H:i:s'),
                "title" => 'Sistema'
            ];

            return $data;
        });
    }

    public function changePassword(ResetRequest $request, Tokens $token) : void
    {
        DB::transaction(function () use ($request, $token) {
            $user = User::find($token->user_id);
            $user->password = Hash::make($request->password_confirm);
            $user->status = 1;
            $user->save();
    
            $token->status = 0;
            $token->save();
        });
    }
}
