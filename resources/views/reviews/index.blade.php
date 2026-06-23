@extends('layouts.app')

@section('title', 'Review')

@section('content')
<section class="hero-panel">
    <h1>Review Konser</h1>
    <p>Daftar review dari pengguna untuk tiket konser.</p>
</section>

<section class="content-card">
    <div class="section-head">
        <div>
            <h2>Data Review</h2>
            <p class="muted" style="margin:6px 0 0;">
                Review terhubung dengan data tiket yang pernah anda tonton
            </p>
        </div>
    </div>

    @if (session('success'))
        <div style="background:#dcfce7;color:#166534;padding:12px;border-radius:10px;margin-bottom:16px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrap">
        <table>
            <tr>
                <th>Konser</th>
                <th>Artis</th>
                <th>Rating</th>
                <th>Komentar</th>
                <th>Aksi</th>
            </tr>

            @forelse ($reviews as $review)
                <tr>
                    <td>{{ $review->ticket?->nama_konser ?? '-' }}</td>
                    <td>{{ $review->ticket?->nama_artis ?? '-' }}</td>
                    <td>{{ $review->rating }}/5</td>
                    <td>{{ $review->komentar }}</td>
                    <td>
                        <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-soft">Detail</a>
                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-primary">Edit</a>

                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Hapus review ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada review.</td>
                </tr>
            @endforelse
        </table>
    </div>
</section>
@endsection