<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private function requireLogin()
    {
        if (!session('pengguna_id')) {
            return redirect()->route('pengguna.login')->with('error', 'Login dulu sebelum booking tiket.');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $query = Booking::with(['ticket.concert.artists', 'ticket.venue', 'refund', 'pengguna'])
            ->orderBy('id', 'desc');

        if (session('pengguna_role') !== 'admin') {
            $query->where('user_id', session('pengguna_id'));
        }

        $booking = $query->get();

        return view('booking.index', compact('booking'));
    }

    public function create()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $tickets = Ticket::with(['concert.artists', 'venue'])
            ->where('stock', '>', 0)
            ->orderBy('tanggal_konser')
            ->orderBy('jam_konser')
            ->get();

        return view('booking.create', compact('tickets'));
    }

    public function store(Request $request)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'kuantitas' => 'required|integer|min:1',
        ]);

        $ticket = Ticket::findOrFail($validated['ticket_id']);

        if ($validated['kuantitas'] > $ticket->stock) {
            return redirect()->back()->with('error', 'Jumlah tiket melebihi stok yang tersedia.');
        }

        Booking::create([
            'user_id' => session('pengguna_id'),
            'ticket_id' => $ticket->id,
            'kuantitas' => $validated['kuantitas'],
            'total_harga' => $ticket->harga * $validated['kuantitas'],
            'status' => 'pending',
        ]);

        $ticket->decrement('stock', $validated['kuantitas']);

        return redirect()->route('booking.index')->with('success', 'Booking berhasil dibuat.');
    }

    public function show(string $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $booking = Booking::with(['ticket.concert.artists', 'ticket.venue', 'refund', 'pengguna'])->findOrFail($id);

        if (session('pengguna_role') !== 'admin' && $booking->user_id !== session('pengguna_id')) {
            abort(403);
        }

        return view('booking.show', compact('booking'));
    }

    public function edit(string $id)
    {
        return redirect()->route('booking.index');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('booking.index');
    }

    public function destroy(string $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $booking = Booking::findOrFail($id);

        if (session('pengguna_role') !== 'admin' && $booking->user_id !== session('pengguna_id')) {
            abort(403);
        }

        $booking->delete();

        return redirect()->route('booking.index')->with('success', 'Booking berhasil dihapus.');
    }
}
