<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\ConnectionController;

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
    // Route pour liker un post
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    // Route pour profile
    Route::get('/profile/{username}', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
    //Route pour modifications
    Route::get('/modifier-profil', [ProfileController::class, 'modifier'])->name('profile.modifier');
    Route::put('/modifier-profil', [ProfileController::class, 'updateModifier'])->name('profile.updateModifier');

    Route::post('/competences', [CompetenceController::class, 'store'])->name('competences.store');

    //Route pour connections 
    Route::post('/users/{user}/connection', [ConnectionController::class, 'connect'])->name('connection');

    //Route pour search 
    Route::get('/searchPosts', [PostController::class, 'searchPosts']);
    Route::get('/searchUsers', [PostController::class, 'searchUsers']);
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
 

// Route pour afficher un utilisateur spécifique
Route::get('/users/{id}', [PostController::class, 'showe'])->name('users.showe');


});

// Route::middleware('api')->group(function () {
//     Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
// });
require __DIR__ . '/auth.php';
