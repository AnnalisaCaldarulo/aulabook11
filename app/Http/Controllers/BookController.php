<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class BookController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['create']),
        ];
    }


    public function indexFilters()
    {
        return view('book.indexFilter');
    }
    public function searchBooks(Request $request)
    {

        $books = Book::search($request->searched)->where('is_published', true)->paginate(10);
        return view('book.index', compact('books'));
    }

    public function publish(Book $book)
    {
        if (!$book->isBookAuthor()) {
            return redirect()->back()->with('message', 'Non sei l\'autore di questo libro, non puoi pubblicarlo!');
        }
        $book->setAccepted(true);
        return redirect()->back()->with('message', 'Libro pubblicato con successo');
    }
    //funzione per nascondere il libro
    public function unpublish(Book $book)
    {
        if (!$book->isBookAuthor()) {
            return redirect()->back()->with('message', 'Non sei l\'autore di questo libro, non puoi rimuovere la pubblicazione!');
        }
        $book->setAccepted(false);
        return redirect()->back()->with('message', 'Libro rimosso corretamente');
    }
    public function downloadBook(Book $book)
    {
        if (file_exists(storage_path('app/' . $book->pdf))) {
            return Storage::download($book->pdf);
        } else {
            return redirect()->route('homepage')->with('errorMessage', 'Il file non è più presente');
        }
    }

    public function indexCategory(Category $category)
    {
        return view('book.indexCategory', compact('category'));
    }
    public function viewPdf(Book $book)
    {
        return view('book.viewPdf', compact('book'));
    }
    public function index()
    {
        $books = Book::where('is_published', true)->orderBy('created_at', 'desc')->paginate(6);
        return view('book.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Book $book)
    {
        return view('book.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // if($book->cover){
        //     Storage::delete($book->cover);
        // }
        // if($book->pdf ){
        //     Storage::delete($book->pdf);
        // }
        $book->delete();

        return redirect()->route('user.profile')->with('message', 'Libro cancellato con successo!');
    }
}
