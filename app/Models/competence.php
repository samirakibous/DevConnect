<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Dans le modèle Competence
public function users()
{
    return $this->belongsToMany(User::class, 'competence_user')->withTimestamps();
}

}
