<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    
public function homepage(){

    $books = Book::orderBy('created_at', 'desc')->get();
    return view('welcome', compact('books'));

}
}
