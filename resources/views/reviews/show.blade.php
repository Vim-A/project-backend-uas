@extends('layouts.app')

@section('title', 'Detail Review')

@section('content')
<section class="hero-panel">
    <h1>Detail Review</h1>
    <p>Informasi lengkap review tiket konser.</p>
</section>

<section class="content-card">
    <div class="section-head">
        <div>
            <h2>{{ $review->ticket?->nama_konser ?? '-' }}</h2>
            <p class="muted" style="margin:6px 0 0;">{{ $review->ticket?->nama_artis ?? '-' }}</p>
        </div>
        <a href="{{ route('reviews.index') }}" class="btn btn-soft">Kembali</a>
    </div>

    <div style="background:white;border:1px solid #d7def0;border-radius:12px;padding:20px;margin-top:8px;">
        <div class="info-row"><span>Konser</span><span>{{ $review->ticket?->nama_konser ?? '-' }}</span></div>
        <div class="info-row"><span>Artis</span><span>{{ $review->ticket?->nama_artis ?? '-' }}</span></div>
        <div class="info-row"><span>Venue</span><span>{{ $review->ticket?->venue?->nama_venue ?? '-' }}</span></div>
        <div class="info-row"><span>Rating</span><span>{{ $review->rating }}/5</span></div>
        <div class="info-row"><span>Reviewer</span><span>{{ $review->nama_reviewer ?? '-' }}</span></div>
        <div style="margin-top:12px;">
            <span style="color:#64748b;font-size:0.875rem;">Komentar</span>
            <p style="margin:6px 0 0;color:#1e293b;">{{ $review->komentar }}</p>
        </div>
    </div>

    <div class="actions" style="margin-top:16px;">
        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Hapus review ini?')">Hapus</button>
        </form>
    </div>
</section>
@endsection