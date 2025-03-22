<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Notifications\CommentNotification;
use Illuminate\Support\Facades\Storage;

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
        $profile_picture_url = url('images/' . $comment->user->profile_picture);

        $post->user->notify(new CommentNotification($comment));
        // Retourner les informations nécessaires pour le commentaire ajouté
        return response()->json([
            'success' => true,
            'comment' => $comment,
            'user' => $comment->user,
            'created_at' => $comment->created_at->diffForHumans(),
            'profile_picture' => $profile_picture_url, 
        ]);
    }

    public function loadMoreComments($postId, Request $request)
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 3);

        // Récupérer les commentaires pour ce post et la page actuelle
        $comments = Comment::where('post_id', $postId)
            ->orderBy('created_at', 'desc')
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        $commentsData = $comments->map(function ($comment) {
            return [
                'userName' => $comment->user->name,
                'userProfilePicture' => Storage::url($comment->user->profile_picture ?? 'images/placeholder.jpg'),
                'createdAt' => $comment->created_at->diffForHumans(),
                'content' => $comment->content,
            ];
        });

        return response()->json(['comments' => $commentsData]);
    }
}
