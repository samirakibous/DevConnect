<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $table = 'languages_programmation';
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'languages_user','user_id', 'language_id');
    }
}
