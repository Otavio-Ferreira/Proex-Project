<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle($request, Closure $next, ...$permissions)
    {
        if (Auth::check()) {
            if (Auth::user()->can($permissions)) {
                return $next($request);
            }
            else{
                return redirect()->back()->with("message", [
                    "type" => "warning",
                    "text" => "Página não encontrada!",
                ]);
            }
        }

        return redirect()->back();
    }
}