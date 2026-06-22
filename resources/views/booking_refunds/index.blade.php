@extends('layouts.app')

@section('title', 'Booking Refund')

@section('content')
<section class="hero-panel">
    <h1>Booking Refund</h1>
    <p>
        @if(session('pengguna_role') === 'admin')
            Admin dapat melihat semua pengajuan refund dan melakukan approve atau reject.
        @else
            Daftar pengajuan refund milik akun kamu.
        @endif
    </p>
</section>

<section class="content-card">
    <div class="section-head">
        <div>
            <h2>Data Pengajuan Refund</h2>
            <p class="muted" style="margin:6px 0 0;">Refund diproses setelah booking berstatus paid.</p>
        </div>
        <a href="{{ route('riwayat.index') }}" class="btn btn-soft">Riwayat Pemesanan</a>
    </div>

    <div class="grid grid-2">
        @forelse ($refunds as $refund)
            <div class="ticket-card">
                <div class="ticket-head">
                    @if($refund->status === 'approved')
                        <span class="badge green">Approved</span>
                    @elseif($refund->status === 'rejected')
                        <span class="badge red">Rejected</span>
                    @else
                        <span class="badge yellow">Pending</span>
                    @endif

                    <h3>{{ $refund->booking?->ticket?->nama_konser ?? '-' }}</h3>
                    <p>{{ $refund->booking?->ticket?->nama_artis ?? '-' }}</p>
                </div>

                <div class="ticket-body">
                    @if(session('pengguna_role') === 'admin')
                        <div class="info-row">
                            <span>Pemesan</span>
                            <span>{{ $refund->booking?->pengguna?->nama ?? $refund->pengguna?->nama ?? 'User ID: ' . $refund->pengguna_id }}</span>
                        </div>
                    @endif

                    <div class="info-row"><span>Venue</span><span>{{ $refund->booking?->ticket?->venue?->nama_venue ?? '-' }}</span></div>
                    <div class="info-row"><span>Tipe Tiket</span><span>{{ $refund->booking?->ticket?->tipe_ticket ?? '-' }}</span></div>
                    <div class="info-row"><span>Jumlah</span><span>{{ $refund->booking?->kuantitas ?? '-' }} tiket</span></div>
                    <div class="info-row"><span>Total Harga</span><span>Rp{{ number_format($refund->booking?->total_harga ?? 0, 0, ',', '.') }}</span></div>
                    <div class="info-row"><span>Status Booking</span><span>{{ ucfirst($refund->booking?->status ?? '-') }}</span></div>

                    <div style="margin-top:14px;">
                        <strong>Alasan Refund:</strong>
                        <p class="muted" style="margin:6px 0 0;">{{ $refund->alasan }}</p>
                    </div>

                    @if($refund->catatan_admin)
                        <div style="margin-top:14px;">
                            <strong>Catatan Admin:</strong>
                            <p class="muted" style="margin:6px 0 0;">{{ $refund->catatan_admin }}</p>
                        </div>
                    @endif

                    <div class="actions" style="margin-top:16px;">
                        @if(session('pengguna_role') === 'admin' && $refund->status === 'pending')
                            <form action="{{ route('booking-refund.approve', $refund->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Setujui refund ini?')">
                                    Approve Refund
                                </button>
                            </form>

                            <form action="{{ route('booking-refund.reject', $refund->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak refund ini?')">
                                    Reject Refund
                                </button>
                            </form>
                        @endif

                        @if(session('pengguna_role') !== 'admin' && $refund->status === 'pending')
                            <form action="{{ route('booking-refund.destroy', $refund->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Batalkan pengajuan refund?')">
                                    Batalkan Refund
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">Belum ada pengajuan refund.</div>
        @endforelse
    </div>
</section>
@endsection
