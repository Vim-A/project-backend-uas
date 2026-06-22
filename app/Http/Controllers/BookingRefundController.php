<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingRefund;
use Illuminate\Http\Request;

class BookingRefundController extends Controller
{
    public function index()
    {
        if (!session('pengguna_id')) {
            return redirect()->route('pengguna.login');
        }

        $query = BookingRefund::with(['booking.ticket.venue', 'booking.pengguna', 'pengguna'])
            ->orderBy('id', 'desc');

        if (session('pengguna_role') !== 'admin') {
            $query->whereHas('booking', function ($booking) {
                $booking->where('user_id', session('pengguna_id'));
            });
        }

        $refunds = $query->get();

        return view('booking_refunds.index', compact('refunds'));
    }

    public function create(Request $request)
    {
        if (!session('pengguna_id')) {
            return redirect()->route('pengguna.login');
        }

        $booking = Booking::with(['ticket.venue', 'refund'])->findOrFail($request->booking_id);

        if (session('pengguna_role') !== 'admin' && $booking->user_id !== session('pengguna_id')) {
            abort(403);
        }

        if ($booking->status !== 'paid') {
            return redirect()->route('booking.index')
                ->with('error', 'Refund hanya bisa diajukan setelah booking berstatus paid.');
        }

        if ($booking->refund) {
            return redirect()->route('booking-refund.index')
                ->with('error', 'Refund untuk booking ini sudah pernah diajukan.');
        }

        return view('booking_refunds.create', compact('booking'));
    }

    public function store(Request $request)
    {
        if (!session('pengguna_id')) {
            return redirect()->route('pengguna.login');
        }

        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'alasan' => 'required|min:5',
        ]);

        $booking = Booking::with('refund')->findOrFail($request->booking_id);

        if (session('pengguna_role') !== 'admin' && $booking->user_id !== session('pengguna_id')) {
            abort(403);
        }

        if ($booking->status !== 'paid') {
            return redirect()->route('booking.index')
                ->with('error', 'Refund hanya bisa diajukan setelah booking berstatus paid.');
        }

        if ($booking->refund) {
            return redirect()->route('booking-refund.index')
                ->with('error', 'Refund untuk booking ini sudah pernah diajukan.');
        }

        BookingRefund::create([
            'booking_id' => $booking->id,
            'pengguna_id' => $booking->user_id,
            'alasan' => $request->alasan,
            'status' => 'pending',
        ]);

        return redirect()->route('booking-refund.index')
            ->with('success', 'Pengajuan refund berhasil dikirim.');
    }

    public function approve($id)
    {
        if (session('pengguna_role') !== 'admin') {
            return redirect()->back()->with('error', 'Akses hanya untuk admin.');
        }

        $refund = BookingRefund::with(['booking.ticket'])->findOrFail($id);

        if ($refund->status !== 'pending') {
            return redirect()->back()->with('error', 'Refund ini sudah diproses.');
        }

        $refund->update([
            'status' => 'approved',
            'catatan_admin' => 'Refund disetujui oleh admin.',
        ]);

        if ($refund->booking) {
            $refund->booking->update([
                'status' => 'refunded',
            ]);

            if ($refund->booking->ticket) {
                $refund->booking->ticket->increment('stock', $refund->booking->kuantitas);
            }
        }

        return redirect()->back()->with('success', 'Refund berhasil disetujui.');
    }

    public function reject($id)
    {
        if (session('pengguna_role') !== 'admin') {
            return redirect()->back()->with('error', 'Akses hanya untuk admin.');
        }

        $refund = BookingRefund::findOrFail($id);

        if ($refund->status !== 'pending') {
            return redirect()->back()->with('error', 'Refund ini sudah diproses.');
        }

        $refund->update([
            'status' => 'rejected',
            'catatan_admin' => 'Refund ditolak oleh admin.',
        ]);

        return redirect()->back()->with('success', 'Refund berhasil ditolak.');
    }

    public function destroy($id)
    {
        if (!session('pengguna_id')) {
            return redirect()->route('pengguna.login');
        }

        $query = BookingRefund::with('booking')->where('id', $id);

        if (session('pengguna_role') !== 'admin') {
            $query->whereHas('booking', function ($booking) {
                $booking->where('user_id', session('pengguna_id'));
            });
        }

        $refund = $query->firstOrFail();

        if ($refund->status !== 'pending') {
            return redirect()->back()->with('error', 'Refund yang sudah diproses tidak bisa dibatalkan.');
        }

        $refund->delete();

        return redirect()->back()->with('success', 'Pengajuan refund berhasil dibatalkan.');
    }
}
