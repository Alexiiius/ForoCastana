<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;

class Thread extends Model
{
    use HasFactory;

    // Devuelve el usuario que creo el hilo
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Devuelve los comentarios asociados al hilo
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    // Devuelve el comentario mas reciente asociado al hilo
    public function latestComment(){
        return $this->comments()->orderBy('created_at', 'desc')->first();
    }

    // Devuelve un booleano que indica si el hilo esta cerrado
    public function isClosed(){
        return $this->is_closed;
    }

    // Cierra el hilo
    public function close(){
        $this->is_closed = true;
        $this->save();
    }

    // Abre el hilo
    public function open(){
        $this->is_closed = false;
        $this->save();
    }

    // Borra el hilo y sus comentarios asociados
    public function delete(){
        $this->comments()->delete();
        parent::delete(); // Llamada al método delete de la clase padre (Model) de Eloquent
    }

    // Devuelve un booleano que indica si el hilo pertenece a un usuario bloqueado
    public function isBlocked(){
        return $this->user->isBlocked();
    }

    // Devuelve un booleano que indica si el hilo pertenece a un usuario administrador
    public function isAdmin(){
        return $this->user->isAdmin();
    }

    // Devuelve un booleano que indica si el hilo pertenece a un usuario
    public function isUser(){
        return $this->user->isUser();
    }

    // Agrega un comentario al hilo
    public function addComment($content){
        $comment = new Comment;
        $comment->content = $content;
        $comment->user_id = auth()->id();
        $comment->thread_id = $this->id;
        $this->comments()->save($comment);

        return $this->touch();
    }

}