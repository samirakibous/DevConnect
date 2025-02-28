<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;

class hashtagController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);


        $tagName = trim(strtolower($request->name));
        $tag = Hashtag::where('name', $tagName)->first();
        if (!$tag) {
            $tag = Hashtag::create(['name' => $tagName]);
            return response()->json(['message' => 'Tag créé avec succès', 'tag' => $tag], 201);
        }

        return response()->json(['message' => 'Tag déjà existant', 'tag' => $tag], 200);
    }
}
