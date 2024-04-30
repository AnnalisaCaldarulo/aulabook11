<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{

    public function homepage()
    {
        $books = Book::where('is_published', true)->orderBy('created_at', 'desc')->take(6)->get();
        // $revisors = User::where('role_id', 2)->where('id', '<>', Auth::id())->get();
        // dd($revisors);
        return view('welcome', compact('books'));
    }


    public function setLanguage($lang)
    {
        App::setLocale($lang);
        session()->put("locale", $lang);
        return redirect()->back();
    }
}
