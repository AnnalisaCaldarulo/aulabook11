<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Book $book)
    {

        $validatedData = $request->validate([
            'content' => 'required',
        ]);

        $book->comments()->create([
            'user_id' => Auth::user()->id,
            'content' => $validatedData['content'],
        ]);

        return redirect()->back();
    }
}
