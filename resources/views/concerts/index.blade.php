@extends('layouts.app')

@section('title', 'Daftar Concert')

@section('content')
<div class="page-shell">
    <section class="hero-panel">
        <h1>Concert</h1>
        <p>Daftar konser BeatMeet berdasarkan artis, tanggal event, status, dan tiket yang tersedia.</p>
    </section>

    <section class="content-card">
        <div class="section-head">
            <div>
                <h2>Daftar Concert</h2>
                <p class="muted" style="margin:6px 0 0;">Data diambil dari tabel concerts dan artists.</p>
            </div>

            <div class="actions">
                <a href="{{ route('home') }}" class="btn btn-soft">Home</a>
                @if(session('pengguna_role') === 'admin')
                    <a href="{{ route('concerts.create') }}" class="btn btn-primary">+ Tambah Concert</a>
                @endif
            </div>
        </div>

        @if($concerts->isEmpty())
            <div class="empty-state">Belum ada data concert.</div>
        @else
            <div class="grid grid-3">
                @foreach($concerts as $concert)
                    @php
                        $statusClass = $concert->status === 'finished' ? 'red' : ($concert->status === 'ongoing' ? 'yellow' : 'green');
                    @endphp

                    <div class="event-card">
                        <img src="{{ asset($concert->poster_url ?? 'resource/image/logo-beatmeet.png') }}"
                             alt="{{ $concert->name }}"
                             style="width:100%;height:220px;object-fit:cover;display:block;background:#17223a;">

                        <div style="padding:18px;">
                            <span class="badge {{ $statusClass }}">{{ ucfirst($concert->status) }}</span>

                            <h3 style="margin:6px 0 6px;">{{ $concert->name }}</h3>
                            <p class="muted small" style="margin:0 0 8px;">
                                {{ $concert->artists->pluck('name')->implode(', ') ?: 'Belum ada artist' }}
                            </p>
                            <p class="small" style="margin:0 0 12px;">
                                {{ $concert->event_date ? $concert->event_date->format('d M Y, H:i') . ' WIB' : '-' }}
                            </p>
                            <p class="small" style="line-height:1.5;min-height:42px;">
                                {{ $concert->description ?? 'Tidak ada deskripsi.' }}
                            </p>

                            <div class="actions" style="margin-top:14px;">
                                <a href="{{ route('concerts.show', $concert->id) }}" class="btn btn-soft">Detail</a>
                                <a href="{{ route('tickets.index') }}" class="btn btn-primary">Lihat Ticket</a>

                                <form action="{{ route('wishlist.store') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="concert_id" value="{{ $concert->id }}">
                                    <button type="submit" class="btn btn-soft">♡ Wishlist</button>
                                </form>

                                @if(session('pengguna_role') === 'admin')
                                    <a href="{{ route('concerts.edit', $concert->id) }}" class="btn btn-dark">Edit</a>

                                    <form action="{{ route('concerts.destroy', $concert->id) }}" method="POST" onsubmit="return confirm('Hapus concert ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
