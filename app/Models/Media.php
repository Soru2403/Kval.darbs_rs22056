<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'type', 'cover_image'];

    // Funkcija priekš vērtējumu sasaistes
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
