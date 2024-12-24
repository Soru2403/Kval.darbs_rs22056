<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    use HasFactory;

    // Norādām laukus, kurus var masveidīgi piešķirt
    protected $fillable = ['content', 'post_id', 'user_id'];

    // Attiecības ar lietotāju (komentāra autoru)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Attiecības ar ierakstu, kuram pieder komentārs
    public function post()
    {
        return $this->belongsTo(ForumPost::class);
    }
}
