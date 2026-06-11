@extends('layouts.app')

@section('title', 'Ajukan Refund')

@section('content')
<style>
    .refund-page {
        min-height: calc(100vh - 70px);
        background: radial-gradient(circle at center, #4b5f9a 0%, #2d3d63 45%, #17243b 100%);
        padding: 70px 0 140px;
    }

    .refund-form {
        width: 55%;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        padding: 26px;
    }

    .refund-form h1 {
        margin-top: 0;
    }

    .info-box {
        border: 1px solid #d7def0;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 18px;
        background: #f8fafc;
    }

    .info-box p {
        margin: 6px 0;
        color: #334155;
    }

    textarea {
        width: 100%;
        min-height: 130px;
        padding: 12px;
        border: 1px solid #17243b;
        border-radius: 10px;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .btn {
        display: inline-block;
        padding: 9px 14px;
        border-radius: 10px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        margin-top: 12px;
    }
    
    .btn-primary {
        background: #ef4765;
        color: white;
    }

    .btn-soft {
        background: #eef3ff;
        color: #0f234a;
        border: 1px solid #b7c7f0;
    }
</style>

<div class="refund-page">
    <div class="refund-form">
        <h1>Ajukan Refund</h1>

        <div class="info-box">
            <p><strong>Konser:</strong> {{ $booking->ticket->nama_konser ?? '-' }}</p>
            <p><strong>Tipe Tiket:</strong> {{ $booking->ticket->tipe_ticket ?? '-' }}</p>
            <p><strong>Jumlah:</strong> {{ $booking->kuantitas }}</p>
            <p><strong>Total Harga:</strong> Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</p>
            <p><strong>Status Booking:</strong> {{ $booking->status }}</p>
        </div>

        <form action="{{ route('booking-refund.store') }}" method="POST">
            @csrf

            <input type="hidden" name="booking_id" value="{{ $booking->id }}">

            <label>Alasan Refund</label>
            <br><br>
            <textarea name="alasan" placeholder="Tulis alasan refund..." required>{{ old('alasan') }}</textarea>

            <br>

            <button type="submit" class="btn btn-primary">Kirim Refund</button>
            <a href="{{ route('riwayat.index') }}" class="btn btn-soft">Batal</a>
        </form>
    </div>
</div>
@endsection
