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
                            @if($riwayat->ticket?->reviews->count() > 0)
                                <button
                                    type="button"
                                    class="btn btn-soft"
                                    onclick="toggleReview('review-{{ $riwayat->id }}')"
                                >
                                    Lihat Review
                                </button>
                            @endif


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
                                @if($riwayat->status === 'paid')
                                    <a href="{{ route('reviews.create', ['ticket_id' => $riwayat->ticket_id]) }}" class="btn btn-primary" style="background-color: #28a745; border-color: #28a745;">
                                        Beri Review
                                    </a>
                            @endif
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
                  @if($riwayat->ticket?->reviews->count() > 0)
                    <tr id="review-{{ $riwayat->id }}" style="display:none;">
                        <td colspan="{{ session('pengguna_role') === 'admin' ? 9 : 8 }}" style="background:#f8fafc;padding:16px;">
                            <strong style="display:block;margin-bottom:10px;">Review untuk {{ $riwayat->ticket->nama_konser }}</strong>
                            @foreach($riwayat->ticket->reviews as $review)
                                <div style="background:white;border:1px solid #d7def0;border-radius:10px;padding:12px;margin-bottom:8px;">
                                    <span style="font-weight:600;">Rating: {{ $review->rating }}/5</span>
                                    <p style="margin:6px 0 0;color:#475569;">{{ $review->komentar }}</p>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="{{ session('pengguna_role') === 'admin' ? 9 : 8 }}">Belum ada riwayat pemesanan.</td>
                </tr>
            @endforelse
        </table>
    </div>
</section>

<script>
function toggleReview(id) {
    const row = document.getElementById(id);
    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}
</script>
@endsection
