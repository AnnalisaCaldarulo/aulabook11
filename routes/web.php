<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PaymentController;

Route::get('/', [PublicController::class, 'homepage'])->name('homepage');

//books
Route::get('/create/book', [BookController::class, 'create'])->name('book.create');
Route::get('/index/book', [BookController::class, 'index'])->name('book.index');
Route::get('/show/book/{book}', [BookController::class, 'show'])->name('book.show');
//download
Route::get('/download/book/{book}', [BookController::class, 'downloadBook'])->name('book.download');
//visua
Route::get('/view/book/{book}', [BookController::class, 'viewPdf'])->name('book.viewPdf');
Route::get('/index/book/category/{category}', [BookController::class, 'indexCategory'])->name('book.category');
//commenti
Route::post('/books/{book}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');

//pagamento
Route::post('/checkout/{book}', [PaymentController::class, 'checkout'])->middleware('auth')->name('checkout');
Route::get('/checkout/success/{purchasedBook}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/checkout/cancel/{purchasedBook}', [PaymentController::class, 'cancel'])->name('payment.cancel');
