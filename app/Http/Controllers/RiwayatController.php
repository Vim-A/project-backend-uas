<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class RiwayatController extends Controller
{
    public function index()
    {
        if (!session('pengguna_id')) {
            return redirect()->route('pengguna.login');
        }

        $query = Booking::with(['ticket.venue', 'ticket.reviews', 'refund', 'pengguna'])
            ->orderBy('id', 'desc');

        if (session('pengguna_role') !== 'admin') {
            $query->where('user_id', session('pengguna_id'));
        }

        $riwayats = $query->get();

        return view('riwayat.index', compact('riwayats'));
    }
}
