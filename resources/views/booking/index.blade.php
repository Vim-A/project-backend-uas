@extends('layouts.app')

@section('title', 'Booking Tiket')

@section('content')
<section class="hero-panel">
    <h1>Booking Tiket</h1>
    <p>Daftar booking tiket konser yang sudah dibuat.</p>
</section>

<section class="content-card">
    <div class="section-head">
        <div>
            <h2>Data Booking</h2>
            <p class="muted" style="margin:6px 0 0;">
                User melihat booking miliknya, admin melihat semua booking.
            </p>
        </div>
        <a href="{{ route('booking.create') }}" class="btn btn-primary">+ Booking Tiket</a>
    </div>

    <div class="grid grid-2">
        @forelse($booking as $item)
            <div class="ticket-card">
                <div class="ticket-head">
                    @if($item->status === 'paid')
                        <span class="badge green">Paid</span>
                    @elseif($item->status === 'refunded')
                        <span class="badge red">Refunded</span>
                    @else
                        <span class="badge yellow">{{ ucfirst($item->status) }}</span>
                    @endif

                    <h3>{{ $item->ticket?->nama_konser ?? '-' }}</h3>
                    <p>{{ $item->ticket?->nama_artis ?? '-' }}</p>
                </div>

                <div class="ticket-body">
                    @if(session('pengguna_role') === 'admin')
                        <div class="info-row">
                            <span>Pemesan</span>
                            <span>{{ $item->pengguna?->nama ?? 'User ID: ' . $item->user_id }}</span>
                        </div>
                    @endif

                    <div class="info-row"><span>Venue</span><span>{{ $item->ticket?->venue?->nama_venue ?? '-' }}</span></div>
                    <div class="info-row"><span>Tipe Ticket</span><span>{{ $item->ticket?->tipe_ticket ?? '-' }}</span></div>
                    <div class="info-row"><span>Jumlah</span><span>{{ $item->kuantitas }} tiket</span></div>
                    <div class="info-row"><span>Total</span><span>Rp{{ number_format($item->total_harga, 0, ',', '.') }}</span></div>

                    <div class="info-row">
                        <span>Status Refund</span>
                        <span>
                            @if($item->refund)
                                @if($item->refund->status === 'approved')
                                    <span class="badge green">Refund: Approved</span>
                                @elseif($item->refund->status === 'rejected')
                                    <span class="badge red">Refund: Rejected</span>
                                @else
                                    <span class="badge yellow">Refund: Pending</span>
                                @endif
                            @else
                                <span class="badge yellow">Belum Refund</span>
                            @endif
                        </span>
                    </div>

                    <div class="actions" style="margin-top:16px;">
                        <a href="{{ route('booking.show', $item->id) }}" class="btn btn-soft">Detail</a>

                        @if($item->status === 'pending')
                            <a href="{{ route('payments.create', ['booking_id' => $item->id]) }}" class="btn btn-primary">Bayar</a>
                        @elseif($item->status === 'paid')
                            <span class="badge green">Sudah Dibayar</span>
                        @elseif($item->status === 'refunded')
                            <span class="badge red">Sudah Refund</span>
                        @endif

                        @if(session('pengguna_role') === 'admin')
                            @if($item->refund && $item->refund->status === 'pending')
                                <form action="{{ route('booking-refund.approve', $item->refund->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('Setujui refund ini?')">
                                        Approve Refund
                                    </button>
                                </form>

                                <form action="{{ route('booking-refund.reject', $item->refund->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak refund ini?')">
                                        Reject Refund
                                    </button>
                                </form>
                            @endif
                        @else
                            @if(!$item->refund && $item->status === 'paid')
                                <a href="{{ route('booking-refund.create', ['booking_id' => $item->id]) }}" class="btn btn-soft">
                                    Ajukan Refund
                                </a>
                            @elseif($item->refund && $item->refund->status === 'pending')
                                <a href="{{ route('booking-refund.index') }}" class="btn btn-soft">
                                    Lihat Refund
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">Belum ada booking.</div>
        @endforelse
    </div>
</section>
@endsection
