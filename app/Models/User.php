<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Thread;
use App\Models\Comment;
use App\Models\Ban;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'language',
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Devuelve los hilos asociados al usuario
    public function threads(){
        return $this->hasMany(Thread::class);
    }

    // Devuelve los comentarios asociados al usuario
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    // Devuelve un string con el motivo del baneo del usuario en caso de estarlo
    public function banReason(): ?string{
        if ($this->isBlocked()){
            return Ban::where('user_id', $this->id)->orderBy('created_at', 'desc')->first()->reason;
        }
    }

    // Devuelve la fecha de expiracion del baneo del usuario en caso de estarlo
    public function banExpirationDate(): ?string{
        if ($this->isBlocked()){
            return Ban::where('user_id', $this->id)->orderBy('created_at', 'desc')->first()->expiration_date;
        }
    }

    // Devuelve un booleano que indica si el usuario esta bloqueado
    public function isBlocked(){
        return $this->is_blocked;
    }

    // Devuelve el id del baneo en caso de estarlo
    public function banId(){
        if ($this->isBlocked()){
            return Ban::where('user_id', $this->id)->orderBy('created_at', 'desc')->first()->id;
        }
    }

    // Bloquea al usuario
    public function block(){
        $this->is_blocked = true;
        $this->save();
    }

    // Desbloquea al usuario
    public function unblock(){
        $this->is_blocked = false;
        $this->save();
    }

    // Devuelve un booleano que indica si el usuario es administrador
    public function isAdmin(){
        return $this->role === 'admin';
    }

    // Devuelve un booleano que indica si el usuario es usuario
    public function isUser(){
        return $this->role === 'user';
    }

    // Devuelve un booleano que indica si el usuario es administrador o usuario
    public function isUserOrAdmin(){
        return $this->isAdmin() || $this->isUser();
    }

    // Cambia el idioma del usuario
    public function changeLanguage($language){
        $this->language = $language;
        $this->save();
    }

}
