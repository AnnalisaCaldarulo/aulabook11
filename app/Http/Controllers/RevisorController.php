<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Mail\BecomeRevisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Artisan;

class RevisorController extends Controller
{
    public function makeRevisor(User $user, $hash)
    {

        if (Crypt::decrypt($hash) != $user->id) {
            return redirect()->back()->with('message', 'Qualcosa è andato storto!');
        }
        Artisan::call('aulabook:makeUserRevisor', ['email' => $user->email]);
        return redirect(route('homepage'))->with('message', 'Complimenti, sei diventato Revisore!');
    }

    public function becomeRevisor()
    {
        if (!Auth::check()) {
            return redirect(route('homepage'))->with('message', 'Non puoi accedere al servizio. Registrati o effettua il login!');
        }
        if (Auth::user()->isAdmin() || Auth::user()->isRevisor()) {
            return redirect()->back()->with('message', 'Sei giá un revisore!');
        }
        Mail::to('admin@aulabook.it')->send(new BecomeRevisor(Auth::user()));
        return redirect()->back()->with('message', 'Hai richiesto di diventare revisore');
    }


    public function index()
    {
        $books = Book::where('review_status', 'pending')
            ->where('user_id', '!=', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->paginate(1);
        return view('revisor.index', compact('books'));
    }
}
