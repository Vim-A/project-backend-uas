@extends('layouts.app')

@section('title', 'Edit')

@section('content')
<section class="hero-panel">
    <h1>Edit Review</h1>
    <p>perbarui rating dan komentar review kamu</p>
</section>

<section class="content-card">
    <div class="section-head">
        <div>
            <h2>{{ $review->ticket?->nama_konser ?? '-' }}</h2>
            <p class="muted" style="margin:6px 0 0;">{{ $review->ticket?->nama_artis ?? '-' }}</p>
        </div>
        <a href="{{ route('reviews.index') }}" class="btn btn-soft">back</a>
    </div>

    @if ($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:10px;margin-bottom:16px;">
            <ul style="margin:0;padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reviews.update', $review->id) }}" method="POST" style="margin-top:8px;">
        @csrf
        @method('PUT')

        <div style="margin-bottom:16px;">
            <label style="display:block;margin-bottom:6px;font-weight:500;">Rating</label>
            <select name="rating" style="width:100%;padding:10px;border:1px solid #d7def0;border-radius:8px;">
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block;margin-bottom:6px;font-weight:500;">Komentar</label>
            <textarea name="komentar" rows="4" style="width:100%;padding:10px;border:1px solid #d7def0;border-radius:8px;resize:vertical;">{{ old('komentar', $review->komentar) }}</textarea>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('reviews.index') }}" class="btn btn-soft">Batal</a>
        </div>
    </form>
</section>
@endsection