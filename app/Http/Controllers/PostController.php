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

class PostController extends Controller
{
    //

    public function index()
    {
        // $post = Post::with('hashtags')->get();
        // dd($post);
        $posts = Post::with('user','comments','hashtags')->latest()->paginate(2);
        $hashtags = hashtag::all();
       
        return view('posts/index', ["posts"=>$posts , "hashtags"=>$hashtags]);
    }

    public function store(Request $request){
    
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'image' => ['required'],
            'hashtags' => ['array'],
        ]);
       

        $imagepath = $request->file('image') ? $request->file('image')->store('posts', 'public') : null;
      $post = Post::create([
            'user_id'=>auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagepath,
        ]);
        
        $post->hashtags()->attach($request->tags);

        return redirect()->route('posts.index');
        
    }
}
