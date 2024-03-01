<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller{

    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:20',
            'content' => 'required|max:50|min:5|string',
        ]);

        $thread = new Thread();
        $thread->title = $request->title;
        $thread->user_id = Auth::id();
        $thread->save();

        $thread->addComment($request->content);

        //Obtenemos el id del hilo creado
        $id = $thread->id;

        return redirect()->route('thread.show', $id);
    }

    // Vista principal de todos los hilos del foro paginados de 5 en 5
    public function main(){

        //Ordernar threads por update
        $threads = Thread::orderBy('updated_at', 'desc')->paginate(5);

        return view('main', ['threads' => $threads]);
    }

    //Muestra un hilo en especifico paginando los comentarios de 5 en 5
    public function show($id){
        $thread = Thread::findOrFail($id);
        $comments = $thread->comments()->paginate(5);
        return view('thread.show', ['thread' => $thread, 'comments' => $comments]);
    }


    // Cerrar un hilo en caso de que el usuario sea administrador o el creador del hilo
    public function close(Thread $thread){
        if ((Auth::user()->isAdmin() || $thread->user->id == Auth::id()) && !$thread->isClosed()) {
            $thread->close();
        }
        return back();
    }

    // Abrir un hilo en caso de que el usuario sea administrador o el creador del hilo
    public function open(Thread $thread){
        if ((Auth::user()->isAdmin() || $thread->user->id == Auth::id()) && $thread->isClosed()) {
            $thread->open();
        }
        return back();
    }

    // Eliminar un hilo en caso de que el usuario sea administrador o el creador del hilo
    public function delete(Thread $thread){

        Thread::findOrFail($thread->id);
        if (Auth::user()->isAdmin() || $thread->user->id == Auth::id() ) {
            $thread->delete();
        }
        
        return redirect()->route('main');
    }

}

?>