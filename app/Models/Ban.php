<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Ban extends Model
{
    use HasFactory;

    // Banea a un usuario
    public static function banUser(User $user, User $admin, string $reason, $expiration){
        $ban = new Ban();
        $ban->user_id = $user->id;
        $ban->admin_id = $admin->id;
        $ban->reason = $reason;
        $ban->ban_end = $expiration;
        $ban->save();
        $user->block();
    }

    // Elimina el baneo de un usuario
    public static function unbanUser(User $user){
        $ban = Ban::find($user->banId());
        $ban->delete();
        $user->unblock();
    }

    // Devuelve el id de usuario asociado al baneo
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    // Devuelve el id de usuario administrador que realizo el baneo
    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Devuelve un string con el motivo del baneo
    public function reason(){
        return $this->reason;
    }

    // Devuelve la fecha de expiracion del baneo
    public function expiration(){
        return $this->ban_end;
    }

    // Devuelve un booleano que indica si el baneo esta expirado
    public function isExpired(){
        return $this->ban_end < now();
    }

}
