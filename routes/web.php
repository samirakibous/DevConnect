<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\CertificationsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProgrammingLanguageController;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::resource('/posts', PostController::class)->only(['index']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::post('/comment/post/{post}', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/loadMoreComments/{postId}', [CommentController::class, 'loadMoreComments']);
    // Route pour liker un post
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    // Route pour profile
    Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
    //Route pour modifications
    Route::get('/modifier-profil', [ProfileController::class, 'modifier'])->name('profile.modifier');
    Route::put('/modifier-profil', [ProfileController::class, 'updateModifier'])->name('profile.updateModifier');
    //Route pour créer un langage de programmation
    Route::post('/add-programming-language', [ProgrammingLanguageController::class, 'store'])->name('add-programming-language.store');

    Route::post('/competences', [CompetenceController::class, 'store'])->name('competences.store');
    Route::post('/certifications', [CertificationsController::class, 'store'])->name('certifications.store');


    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    
    //Route pour conversation
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');

    Route::post('/conversations/{id}/messages', [MessageController::class, 'store'])->name('messages.store');


    //Route pour connections 
    Route::post('/users/{user}/connection', [ConnectionController::class, 'connect'])->name('connection');

    //Route pour search 
    Route::get('/searchPosts', [PostController::class, 'searchPosts']);
    Route::get('/searchUsers', [PostController::class, 'searchUsers']);
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');


    // Route pour afficher un utilisateur spécifique
    Route::get('/users/{id}', [PostController::class, 'showe'])->name('users.showe');

    //partage
    // Route::get('/posts/{id}', [PostController::class, 'viewPost'])->name('posts.view');

    //chat

    // Route::get('/chat/{user}', [ChatController::class, 'index'])->name('chat.show');
    // Route::post('/messages/send', [ChatController::class, 'sendMessage'])->name('messages.send');
    // Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');

});

// Route::get('/conversations', function () {
//     $user = Auth::user();
//     $conversations = Conversation::where('user_one', $user->id)
//         ->orWhere('user_two', $user->id)
//         ->get();

//     return view('conversations.index', compact('conversations'));
// })->middleware('auth');


// Route::get('/messages/{conversation}', function ($conversationId) {
//     $conversation = Conversation::findOrFail($conversationId);
//     $messages = Message::where('conversation_id', $conversationId)->get();

//     return view('messages.show', compact('conversation', 'messages'));
// })->middleware('auth')->name('messages.show');


// Route::post('/messages/{conversation}', function ($conversationId) {
//     request()->validate(['message' => 'required']);

//     Message::create([
//         'conversation_id' => $conversationId,
//         'sender_id' => auth()->id(),
//         'message' => request('message')
//     ]);

//     return redirect()->back();
// })->middleware('auth')->name('messages.send');

// Route::get('/conversations/create', [ConversationController::class, 'create'])->name('conversations.create');
// Route::post('/conversations', [ConversationController::class, 'store'])->name('conversations.store');

// Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');


// Route::resource('conversations', ConversationController::class);

// Route pour accepter la connexion
Route::post('/connections/accept/{userId}', [ConnectionController::class, 'accept'])->name('connections.accept');

// Route pour refuser la connexion
Route::post('/connections/deny/{userId}', [ConnectionController::class, 'deny'])->name('connections.deny');



// Route::middleware('api')->group(function () {
//     Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
// });
require __DIR__ . '/auth.php';
