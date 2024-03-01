<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Devuelve el usuario que ha escrito el comentario
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Devuelve el hilo al que pertenece el comentario
    public function thread(){
        return $this->belongsTo(Thread::class);
    }

    // Borra el comentario
    public function delete(){
        parent::delete(); // Llamada al método delete de la clase padre (Model) de Eloquent
    }

}
