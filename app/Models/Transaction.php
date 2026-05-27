<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'publisher_id',
        'amount',
        'publisher_cut',
        'admin_cut',
        'status',
    ];

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function publisher() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
