<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'jumlah_bayar',
        'metode_pembayaran',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
