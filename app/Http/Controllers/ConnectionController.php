<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ConnectionController extends Controller
{
    public function connect(User $user)
    {
        $user->connections()->sync(auth()->user()->id);
        return response()->json([
            'success' => true,
        ]);
    }
}
