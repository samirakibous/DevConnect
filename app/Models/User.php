<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'certifications',
         'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function connections()
    {
        return $this->belongsToMany(User::class, 'connections', 'user_id', 'connected_user_id');
    }



    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function certificate()
    {
        return $this->hasMany(certification::class);
    }

    // Dans le modèle User
    public function competences()
    {
        return $this->belongsToMany(Competence::class, 'competence_user')->withTimestamps();
    }





    public function programmingLanguages()
    {
        return $this->belongsToMany(programming_langage::class, 'user_programming_languages');
    }

    public function connectedUsers()
    {
        return $this->belongsToMany(User::class, 'connections', 'user_id', 'connected_user_id');
    }
    

    public function messages()
    {
        return $this->hasMany(Message::class);
    }



    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_likes');
    }
}
