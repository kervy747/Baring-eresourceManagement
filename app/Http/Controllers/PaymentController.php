<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\ActivityLog;
use App\Models\Book;  

class PaymentController extends Controller
{
    public function show(Book $book)
    {
        return view('books.payment', compact('book'));
    }

    public function process(Book $book)
    {
        $alreadyPurchased = Transaction::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->where('status', 'completed')
            ->exists();

        if ($alreadyPurchased) {
            return redirect()->back()->with('error', 'You already own this book.');
        }

        $amount       = $book->price;
        $publisherCut = $amount * 0.80;
        $adminCut     = $amount * 0.20;

        Transaction::create([
            'user_id'       => auth()->id(),
            'book_id'       => $book->id,
            'publisher_id'  => $book->user_id,
            'amount'        => $amount,
            'publisher_cut' => $publisherCut,
            'admin_cut'     => $adminCut,
            'status'        => 'completed',
        ]);

        // Credit the publisher
        \App\Models\User::where('id', $book->user_id)
            ->increment('balance', $publisherCut);

        // Credit the superadmin
        \App\Models\User::where('role', 'superadmin')
            ->increment('balance', $adminCut);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'book_id'     => $book->id,
            'action'      => 'purchased',
            'description' => auth()->user()->fname . ' purchased ' . $book->title,
        ]);

        return redirect('/books/' . $book->id)->with('success', 'Purchase successful!');
    }
}