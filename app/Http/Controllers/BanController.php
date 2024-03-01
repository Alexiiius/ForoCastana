<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Ban;
use Carbon\Carbon;

class BanController extends Controller
{
    //Banea un usuario
    public function ban(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'ban_end' => 'required|date|after:now',
        ]);

        $user = User::find($id);
        // Banea al usuario
        // usuario admim motivo expiracion
        Ban::banUser($user, Auth::user(), $request->reason, $request->ban_end);

        return Redirect::route('user.show', $user->id)->with('status', 'user-banned');
    }

    //Desbanea un usuario
    public function unban(Request $request, $id): RedirectResponse
    {
        $user = User::find($id);
        // Desbanea al usuario
        //$user = idusuario
        Ban::unbanUser($user);

        return Redirect::route('user.show', $user->id)->with('status', 'user-unbanned');
    }

}
