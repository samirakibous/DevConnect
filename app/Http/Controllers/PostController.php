<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Comment;
use App\Models\hashtag;
use App\Models\User;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tag;
use App\Http\Controllers\Storage;

class PostController extends Controller
{
    //

    public function index()
    {
        // $post = Post::with('hashtags')->get();
        // dd($post);
        $posts = Post::with('user', 'comments', 'hashtags')->latest()->paginate(2);
        $hashtags = hashtag::all();

        return view('posts/index', ["posts" => $posts, "hashtags" => $hashtags]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'image' => ['required'],
            'hashtags' => ['array'],
        ]);


        $imagepath = $request->file('image') ? $request->file('image')->store('posts', 'public') : null;
        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagepath,
        ]);

        $post->hashtags()->attach($request->tags);

        return redirect()->route('posts.index');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== auth()->id()) {
            return redirect()->route('posts.index')->with('error', 'Vous ne pouvez pas supprimer ce post.');
        }

        // $post->hashtags()->detach();

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Le post a été supprimé avec succès.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $hashtags = Hashtag::all();
        return view('posts.edit', compact('post', 'hashtags'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'tags' => 'array',
            'image' => 'nullable|image|max:2048'
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->description = $request->description;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        $post->hashtags()->sync($request->tags ?? []);

        return redirect()->route('posts.index', $post->id)->with('success', 'Post mis à jour avec succès.');
    }

    public function like($id)
{
    $post = Post::findOrFail($id);
    $user = auth()->user();

    if ($post->likes()->where('user_id', $user->id)->exists()) {
        $post->likes()->detach($user->id);
        $liked = false;
    } else {
        $post->likes()->attach($user->id);
        $liked = true;
    }

    return response()->json([
        'liked' => $liked,
        'likes_count' => $post->likes()->count()
    ]);
}

}
