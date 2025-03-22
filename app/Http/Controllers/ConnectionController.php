<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\connection;

class ConnectionController extends Controller
{
    public function connect(User $user)
    {
        $user->connections()->sync(auth()->user()->id);
        return response()->json([
            'success' => true,
        ]);
    }

    public function accept($id)
    {
        $connection = Connection::find($id);
        if (!$connection) {
            return response()->json(['success' => false, 'message' => 'Connexion non trouvée']);
        }
    
        $connection->status = 'accepter';
        $connection->save();
    
        return response()->json(['success' => true, 'message' => 'Connexion acceptée avec succès']);
    }
    
    public function deny($id)
    {
        $connection = Connection::find($id);
        if (!$connection) {
            return response()->json(['success' => false, 'message' => 'Connexion non trouvée']);
        }
    
        $connection->status = 'refuser';
        $connection->save();
    
        return response()->json(['success' => true, 'message' => 'Connexion refusée avec succès']);
    }
    
    // Delete a connection by connection ID
    public function delete(Request $request, $connectionId)
    {
        $connection = Connection::find($connectionId);

        if ($connection) {
            $connection->delete();

            return response()->json(['message' => 'Connection deleted']);
        }

        return response()->json(['message' => 'Connection not found'], 404);
    }
}
