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
            <p class="muted" style="margin:6px 0 0;">Data diambil dari tabel booking.</p>
        </div>
        <a href="{{ route('booking.create') }}" class="btn btn-primary">Booking Baru</a>
    </div>

    <div class="table-wrap">
        <table>
            <tr>
                <th>Konser</th>
                <th>Artis</th>
                <th>Venue</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            @forelse($riwayats as $riwayat)
                <tr>
                    <td>{{ $riwayat->ticket?->nama_konser ?? '-' }}</td>
                    <td>{{ $riwayat->ticket?->nama_artis ?? '-' }}</td>
                    <td>{{ $riwayat->ticket?->venue?->nama_venue ?? '-' }}</td>
                    <td>{{ $riwayat->kuantitas }}</td>
                    <td>Rp{{ number_format($riwayat->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $riwayat->status === 'paid' ? 'green' : 'yellow' }}">{{ ucfirst($riwayat->status) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('booking.show', $riwayat->id) }}" class="btn btn-soft">Detail</a>

                        @if (!$riwayat->refund)
                            <a href="{{ route('booking-refund.create', ['booking_id' => $riwayat->id]) }}" class="btn btn-primary">
                            Ajukan Refund
                            </a>
                        @else
                        <span class="badge {{ $riwayat->refund->status === 'approved' ?     'green' : ($riwayat->refund->status === 'rejected' ? 'red' : 'yellow') }}">
                            Refund: {{ ucfirst($riwayat->refund->status) }}
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada riwayat pemesanan.</td>
                </tr>
            @endforelse
        </table>
    </div>
</section>
@endsection
