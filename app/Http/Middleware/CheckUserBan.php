<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Ban;

class CheckUserBan
{

    // Middleware que verifica si el usuario esta bloqueado y lo desloguea. 
    // Tambien verifica si el ban ya expiro y lo desbloquea.
    public function handle(Request $request, Closure $next){
        $user = $request->user();

        if ($user === null) {
            return $next($request);
        }

        if ($user->isBlocked()) {
            $ban = Ban::find($user->banId());

            if ($ban->isExpired()) {
                Ban::unbanUser($user);
            } else {
                Auth::logout();
                return redirect()->route('principal')->with('error', __('Your account is blocked. Reason: :reason', ['reason' => $ban->reason()]));
            }

        }
    
        return $next($request);
    }
}
