<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Mail\ResponseReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $bookAuthor = $book->user;
        //creaizione del record nella tabella review con l'id dello user revisore e il contenuto del messaggio
        $book->reviews()->create([
            'user_id' => $request->user()->id,
            'content' => $request->content,
        ]);
        $book->update([
            'review_status' => 'completed',
        ]);
        $response = $request->content;
        $userEmail = $bookAuthor->email;
        Mail::to($userEmail)->queue(new ResponseReview($response, $book));
        return redirect(route('revisor.index'))->with('message', 'La recensione è stata inviata');
    }
}
