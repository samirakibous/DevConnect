<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Comment;
use App\Models\hashtag;
use App\Models\User;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tag;
use App\Http\Controllers\Storage;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    //

    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        $posts = Post::with('user', 'comments', 'hashtags')->latest()->paginate(2);

        $hashtags = hashtag::all();

        $currentUser = auth()->user();
        foreach ($users as $user) {
            $user->competences = $user->competences;
        }

        return view('posts.index', [
            'posts' => $posts,
            'hashtags' => $hashtags,
            'users' => $users,
            'user' => $currentUser // Passer l'utilisateur authentifié à la vue
        ]);
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

    // public function toggleLike(Post $post)
    // {
    //     $like = $post->likes()->where('user_id', Auth::id())->first();
    //     if ($like) {
    //         $like->delete();
    //         $liked = false;
    //     } else {
    //         $post->likes()->create([
    //             'user_id' => Auth::id(),
    //         ]);
    //         $liked = true;
    //     }

    //     $count = $post->likes()->count();
    //     return response()->json(['liked' => $liked, 'count' => $count]);
    // }


    public function like($postId)
    {
        try {
            // Récupérer l'utilisateur connecté
            $user = Auth::user();
            if (!$user) {
                return response()->json(['message' => 'Utilisateur non authentifié'], 401);
            }

            // Vérifier si le post existe
            $post = Post::find($postId);
            if (!$post) {
                return response()->json(['message' => 'Post introuvable'], 404);
            }

            // Vérifier si l'utilisateur a déjà liké ce post
            $existingLike = Like::where('post_id', $post->id)
                ->where('user_id', $user->id)
                ->first();

            if ($existingLike) {
                // Supprimer le like (toggle)
                $existingLike->delete();
                $count = $post->likes()->count();
                return response()->json(['message' => 'Like supprimé', 'liked' => false, 'count' => $count]);
            }

            // Ajouter un nouveau like
            Like::create([
                'post_id' => $post->id,
                'user_id' => $user->id,
            ]);
            $count = $post->likes()->count();
            return response()->json(['message' => 'Post liké avec succès', 'liked' => true, 'count' => $count]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur serveur', 'error' => $e->getMessage()], 500);
        }
    }

    public function searchPosts(Request $request)
    {
        $query = $request->input('query');
        $posts = Post::where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();

        return response()->json(['success' => true, 'posts' => $posts]);
    }

    // Méthode pour rechercher des utilisateurs
    public function searchUsers(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $query = $request->input('query');

        // Effectuer la recherche des utilisateurs
        $users = User::where('name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->get();

        return response()->json(['success' => true, 'users' => $users]);
    }


    // Dans PostController.php

    public function show(Request $request)
    {
        $query = $request->query('query');

        // Recherche des utilisateurs
        $users = User::where('name', 'like', '%' . $query . '%')->get();

        // Recherche des posts
        $posts = Post::where('title', 'like', '%' . $query . '%')->get();

        return view('posts.show', compact('users', 'posts'));
    }





}
