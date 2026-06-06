@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<section class="hero-panel">
    <h1>Detail Booking</h1>
    <p>Ringkasan pemesanan tiket konser.</p>
</section>

<section class="ticket-card">
    <div class="ticket-head">
        <span class="badge {{ $booking->status === 'paid' ? 'green' : 'yellow' }}">{{ ucfirst($booking->status) }}</span>
        <h3>{{ $booking->ticket?->nama_konser ?? '-' }}</h3>
        <p>{{ $booking->ticket?->nama_artis ?? '-' }}</p>
    </div>
    <div class="ticket-body">
        <div class="info-row"><span>Venue</span><span>{{ $booking->ticket?->venue?->nama_venue ?? '-' }}</span></div>
        <div class="info-row"><span>Tipe Ticket</span><span>{{ $booking->ticket?->tipe_ticket ?? '-' }}</span></div>
        <div class="info-row"><span>Jumlah</span><span>{{ $booking->kuantitas }} tiket</span></div>
        <div class="info-row"><span>Total</span><span>Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</span></div>
        <div class="actions" style="margin-top:16px;">
            @if($booking->status === 'pending')
                <a href="{{ route('payments.create', ['booking_id' => $booking->id]) }}" class="btn btn-primary">Bayar Sekarang</a>
            @endif
            <a href="{{ route('booking.index') }}" class="btn btn-soft">Kembali</a>
        </div>
    </div>
</section>
@endsection
