<?php

namespace App\Models;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasedBook extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'user_id',
        'book_id',
        'price',
        'payment_status',
        'session_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function getDescriptionSubstring()
    {

        $book = Book::find($this->book_id);

        if (strlen($book->description) > 20) {
            return substr($book->description, 0, 30) . '...';
        } else {
            return $book->description;
        }
    }
}
