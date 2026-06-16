<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayats = Booking::with(['ticket.venue', 'refund'])
            ->orderBy('id', 'desc')
            ->get();

        return view('riwayat.index', compact('riwayats'));
    }
}