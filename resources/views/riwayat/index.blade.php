@extends('layouts.app')

@section('title', 'Riwayat Pemesanan')

@section('content')
<section class="hero-panel">
    <h1>Riwayat Pemesanan</h1>
    <p>Riwayat booking dan pembayaran tiket konser.</p>
</section>

<section class="content-card">
    <div class="section-head">
        <div>
            <h2>History Booking</h2>
            <p class="muted" style="margin:6px 0 0;">
                @if(session('pengguna_role') === 'admin')
                    Admin dapat melihat semua booking dan memproses refund yang diajukan user.
                @else
                    Data diambil dari booking milik akun kamu.
                @endif
            </p>
        </div>
        <a href="{{ route('booking.create') }}" class="btn btn-primary">Booking Baru</a>
    </div>

    <div class="table-wrap">
        <table>
            <tr>
                @if(session('pengguna_role') === 'admin')
                    <th>Pemesan</th>
                @endif
                <th>Konser</th>
                <th>Artis</th>
                <th>Venue</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Status Booking</th>
                <th>Status Refund</th>
                <th>Aksi</th>
            </tr>

            @forelse($riwayats as $riwayat)
                <tr>
                    @if(session('pengguna_role') === 'admin')
                        <td>{{ $riwayat->pengguna?->nama ?? 'User ID: ' . $riwayat->user_id }}</td>
                    @endif

                    <td>{{ $riwayat->ticket?->nama_konser ?? '-' }}</td>
                    <td>{{ $riwayat->ticket?->nama_artis ?? '-' }}</td>
                    <td>{{ $riwayat->ticket?->venue?->nama_venue ?? '-' }}</td>
                    <td>{{ $riwayat->kuantitas }}</td>
                    <td>Rp{{ number_format($riwayat->total_harga, 0, ',', '.') }}</td>

                    <td>
                        @if($riwayat->status === 'paid')
                            <span class="badge green">Paid</span>
                        @elseif($riwayat->status === 'refunded')
                            <span class="badge red">Refunded</span>
                        @else
                            <span class="badge yellow">{{ ucfirst($riwayat->status) }}</span>
                        @endif
                    </td>

                    <td>
                        @if($riwayat->refund)
                            @if($riwayat->refund->status === 'approved')
                                <span class="badge green">Refund: Approved</span>
                            @elseif($riwayat->refund->status === 'rejected')
                                <span class="badge red">Refund: Rejected</span>
                            @else
                                <span class="badge yellow">Refund: Pending</span>
                            @endif
                        @else
                            <span class="badge yellow">Belum Refund</span>
                        @endif
                    </td>

                    <td>
                        <div class="actions">
                            <a href="{{ route('booking.show', $riwayat->id) }}" class="btn btn-soft">Detail</a>

                            @if(session('pengguna_role') === 'admin')
                                @if($riwayat->refund && $riwayat->refund->status === 'pending')
                                    <form action="{{ route('booking-refund.approve', $riwayat->refund->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Setujui refund ini?')">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('booking-refund.reject', $riwayat->refund->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak refund ini?')">
                                            Reject
                                        </button>
                                    </form>
                                @endif
                            @else
                                @if(!$riwayat->refund && $riwayat->status === 'paid')
                                    <a href="{{ route('booking-refund.create', ['booking_id' => $riwayat->id]) }}" class="btn btn-primary">
                                        Ajukan Refund
                                    </a>
                                @elseif($riwayat->refund)
                                    <a href="{{ route('booking-refund.index') }}" class="btn btn-soft">
                                        Lihat Refund
                                    </a>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ session('pengguna_role') === 'admin' ? 9 : 8 }}">Belum ada riwayat pemesanan.</td>
                </tr>
            @endforelse
        </table>
    </div>
</section>
@endsection
