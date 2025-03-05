<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function store(Request $request, Post $post)
    {
        $user_comment = $request->validate([
            'content' => 'required|min:3|string'
        ]);
    
        $comment = new Comment($user_comment);
        $comment->user_id = auth()->id();
        $comment->post_id = $post->id;
        $comment->save();
        $profile_picture_url = url('images/'.$comment->user->profile_picture);

        // Retourner les informations nécessaires pour le commentaire ajouté
        return response()->json([
            'success' => true,
            'comment' => $comment,
            'user' => $comment->user,
            'created_at' => $comment->created_at->diffForHumans(),
            'profile_picture' => $profile_picture_url
        ]);
    }
    
}
