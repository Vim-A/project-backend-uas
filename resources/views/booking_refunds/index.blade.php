@extends('layouts.app')

@section('title', 'Booking Refund')

@section('content')
<style>
    .refund-page {
        min-height: calc(100vh - 70px);
        background: radial-gradient(circle at center, #4b5f9a 0%, #2d3d63 45%, #17243b 100%);
        padding: 70px 0 140px;
    }

    .refund-wrapper {
        width: 78%;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        padding: 26px;
    }

    .refund-header {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: center;
        margin-bottom: 20px;
    }

    .refund-header h1 {
        margin: 0;
        color: #111827;
    }

    .refund-header p {
        margin: 6px 0 0;
        color: #5c6680;
    }

    .refund-card {
        border: 1px solid #d7def0;
        border-radius: 14px;
        padding: 18px;
        margin-bottom: 14px;
    }

    .refund-card h3 {
        margin: 0 0 6px;
        color: #111827;
    }

    .refund-card p {
        margin: 4px 0;
        color: #5c6680;
        font-size: 14px;
    }

    .status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: bold;
    }

    .pending {
        background: #fef3c7;
        color: #92400e;
    }

    .approved {
        background: #dcfce7;
        color: #166534;
    }

    .rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn {
        display: inline-block;
        padding: 9px 14px;
        border-radius: 10px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        margin-right: 6px;
    }

    .btn-soft {
        background: #eef3ff;
        color: #0f234a;
        border: 1px solid #b7c7f0;
    }

    .btn-primary {
        background: #ef4765;
        color: white;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-success {
        background: #22c55e;
        color: white;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 14px;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 14px;
    }
</style>

<div class="refund-page">
    <div class="refund-wrapper">
        <div class="refund-header">
            <div>
                <h1>Booking Refund</h1>
                <p>Halaman untuk melihat dan mengelola pengajuan refund tiket.</p>
            </div>

            <a href="{{ route('riwayat.index') }}" class="btn btn-soft">Riwayat Pemesanan</a>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if ($refunds->isEmpty())
            <p>Belum ada pengajuan refund.</p>
        @else
            @foreach ($refunds as $refund)
                <div class="refund-card">
                    <h3>{{ $refund->booking->ticket->nama_konser ?? '-' }}</h3>

                    <p><strong>Tipe Tiket:</strong> {{ $refund->booking->ticket->tipe_ticket ?? '-' }}</p>
                    <p><strong>Jumlah:</strong> {{ $refund->booking->kuantitas ?? '-' }}</p>
                    <p><strong>Total Harga:</strong> Rp{{ number_format($refund->booking->total_harga ?? 0, 0, ',', '.') }}</p>
                    <p><strong>Alasan:</strong> {{ $refund->alasan }}</p>
                    <p><strong>Status:</strong>
                        <span class="status {{ $refund->status }}">
                            {{ ucfirst($refund->status) }}
                        </span>
                    </p>

                    @if ($refund->catatan_admin)
                        <p><strong>Catatan Admin:</strong> {{ $refund->catatan_admin }}</p>
                    @endif

                    <div style="margin-top: 12px;">
                        @if (session('pengguna_role') === 'admin' && $refund->status === 'pending')
                            <form action="{{ route('booking-refund.approve', $refund->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success">Approve</button>
                            </form>

                            <form action="{{ route('booking-refund.reject', $refund->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-danger">Reject</button>
                            </form>
                        @endif

                        @if (session('pengguna_role') !== 'admin' && $refund->status === 'pending')
                            <form action="{{ route('booking-refund.destroy', $refund->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('Batalkan pengajuan refund?')">Batalkan</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
