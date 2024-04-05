<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Book;
use App\Models\Comment;
use App\Models\PurchasedBook;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    public function isRevisor()
    {
        return $this->role_id == 2;
    }
    public function isAdmin()
    {
        return $this->role_id == 1;
    }
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function purchasedBooks(): HasMany
    {
        return $this->hasMany(PurchasedBook::class);
    }

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
