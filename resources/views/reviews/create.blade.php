@extends('layouts.app')

@section('title', 'Tambah Review')

@section('content')
<section class="hero-panel">
    <h1>Tambah Review</h1>
    <p>Berikan penilaian untuk tiket konser yang dipilih.</p>
</section>

<section class="content-card">
    <div class="section-head">
        <div>
            <h2>{{ $ticket->nama_konser }}</h2>
            <p class="muted" style="margin:6px 0 0;">
                {{ $ticket->nama_artis }} - {{ $ticket->venue?->nama_venue ?? '-' }}
            </p>
        </div>

        <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-soft">
            Kembali ke Tiket
        </a>
    </div>

    <form action="{{ route('reviews.store') }}" method="POST">
        @csrf

        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

        <div style="margin-bottom:16px;">
            <label>Rating</label>
            <select name="rating" required style="width:100%;padding:12px;border-radius:10px;border:1px solid #94a3b8;margin-top:8px;">
                <option value="">Pilih rating</option>
                <option value="5">5 - Sangat Bagus</option>
                <option value="4">4 - Bagus</option>
                <option value="3">3 - Cukup</option>
                <option value="2">2 - Kurang</option>
                <option value="1">1 - Buruk</option>
            </select>
        </div>

        <div style="margin-bottom:16px;">
            <label>Komentar</label>
            <textarea name="komentar" rows="5" required placeholder="Tulis review kamu..."
                style="width:100%;padding:12px;border-radius:10px;border:1px solid #94a3b8;margin-top:8px;">{{ old('komentar') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Review
        </button>
    </form>
</section>
@endsection