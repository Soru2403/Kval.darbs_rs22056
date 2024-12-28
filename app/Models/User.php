<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\ForumPost;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Saņem visus lietotāja forumu ierakstus.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forumPosts()
    {
        // Šī attiecība norāda, ka lietotājam var būt vairāki forumu ieraksti
        return $this->hasMany(ForumPost::class);
    }

    /**
     * Pārbauda, vai lietotājs ir administrators.
     * 
     * @return bool
     */
    public function isAdmin()
    {
        // Šis pārbauda, vai lietotājam ir 'admin' loma
        return $this->role === 'admin';  // Ja 'role' ir 'admin', atgriežam true, citādi false
    }
}