<?php

namespace App\Models;

use OpenAI;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;


    protected $fillable =
    [
        'title',
        'description',
        'pdf',
        'user_id',
        'category_id', 'cover'
    ];


    public static function generateImage($image, $promptTokens)
    {
        //OpenAI
        $client = OpenAI::client(config('app.open_ai_key'));
        try {
            $response = $client->images()->create([
                'prompt' => $promptTokens,
                'n' => 1,
                'size' => config('app.open_ai_size'),
                'response_format' => 'b64_json',
            ]);
            // Decodifica l'immagine in base64 in una stringa binaria
            $b64_img = base64_decode(strval($response->data[0]['b64_json']));

            if ($image) {
                Storage::disk('public')->delete($image);
            }

            // Crea un nuovo file PNG con la stringa binaria 
            $image = 'upload/' . uniqid() . ".png";

            Storage::disk('public')->put($image, $b64_img);
        } catch (\Exception $e) { //recupero errori generati dall'API
            $message = $e->getMessage();
            session()->flash('errorMessage', "$message");
        }
        return $image;
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function getDescriptionSubstring()
    {
        if (strlen($this->description) > 20) {
            return substr($this->description, 0, 30) . '...';
        }
        return $this->description;
    }
}
