<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class PermissionMiddleware
{
    public function handle($request, Closure $next, ...$permissions)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->active_role) {
            return redirect()->route('dashboard')->with("message", [
                "type" => "warning",
                "text" => "Por favor, selecione um perfil para continuar.",
            ]);
        }

        $activeRole = Role::findByName($user->active_role);

        foreach ($permissions as $permission) {
            if (!$activeRole->hasPermissionTo($permission)) {
                return to_route('home.index');
            }
        }
        
        // Se o loop terminar, o perfil tem todas as permissões.
        return $next($request);
    }
}
