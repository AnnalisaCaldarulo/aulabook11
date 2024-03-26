<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;


    protected $fillable =
    [
        'title',
        'description',
        'pdf',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDescriptionSubstring()
    {
        if (strlen($this->description) > 20) {
            return substr($this->description, 0, 30) . '...';
        }
        return $this->description;
    }
}
