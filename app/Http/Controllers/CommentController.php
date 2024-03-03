<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    
    // Almacena un comentario en un hilo
    public function store(Request $request, Thread $thread){

        // Comprueba si el hilo está cerrado
        if ($thread->is_closed) {
            return back()->withErrors(['thread_closed' => __('The thread is closed.')]);
        }

        $request->validate([
            'content' => ['required', 'string', 'max:50', 'min:5'],
        ]);
    
        $comment = new Comment;
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->thread_id = $thread->id;
        $thread->comments()->save($comment);
        
        //Hace update al thread
        $thread->touch();
    
        return back();
    }

    // Elimina un comentario
    public function delete(Comment $comment){

        if ($comment->user_id != Auth::id() && !Auth::user()->isAdmin()) {
            return back();
        }

        $comment->delete();
        return back();
    }


}
