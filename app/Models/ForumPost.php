<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    // Norādām laukus, kurus var masveidīgi piešķirt
    protected $fillable = ['title', 'content', 'keywords', 'user_id'];

    // Attiecības ar lietotāju (ieraksta autoru)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Attiecības ar komentāriem, kuram pieder ieraksts
    public function comments()
    {
        return $this->hasMany(ForumComment::class, 'post_id');
    }
}



