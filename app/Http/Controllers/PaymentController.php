<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Book;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Models\PurchasedBook;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function checkout(Book $book)
    {
        // creo un tentativo di acquisto
        $purchasedBook = PurchasedBook::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'price' => $book->price,
            'payment_status' => 'pending',
        ]);

        //PRIMO CONTROLLO   
        if ($book->price == 0) {
            $purchasedBook->payment_status = 'success';
            $purchasedBook->save();
            return redirect()->route('welcome')->with('message', 'Aggiunto alla libreria con successo');
        }

        //altrimenti: pagamento

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => $purchasedBook->price * 100,
                        'product_data' => ['name' => $book->title,],
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success', compact('purchasedBook')) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel', compact('purchasedBook')) . '?session_id={CHECKOUT_SESSION_ID}',

        ]);

        $purchasedBook->update([
            // Payment intent da inserire nel caso si voglia salvare
            //'payment_intent' => $session->payment_intent,
            'session_id' => $session->id,
        ]);

        return redirect($session->url);
    }

    public function success(PurchasedBook $purchasedBook, Request $request)
    {
        $session_id = $request->input('session_id');

        if ($purchasedBook->session_id !== $session_id) {

            $message = 'C\'è stato un errore con il pagamento';
        } else {
            $purchasedBook->update([
                'payment_status' => 'success',
            ]);

            $title = $purchasedBook->book->title;
            $message = "Pagamento effettuato con successo! Hai acquistato \" $title \", correttamente.";
        }

        return redirect()->route('welcome')->with('message', $message);
    }


    public function cancel(PurchasedBook $purchasedBook, Request $request)
    {
        $session_id = $request->input('session_id');

        if ($purchasedBook->session_id !== $session_id) {
            $message = 'C\'è stato un errore con il pagamento';
        } else {
            $purchasedBook->update([
                'payment_status' => 'canceled',
            ]);
            $message = 'Pagamento cancellato';
        }

        return redirect()->route('welcome')->with('message', $message);
    }
}
