<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media'; // Название таблицы в БД
    protected $fillable = ['title', 'description', 'type', 'creator', 'release_year', 'genre', 'image_url'];
}
