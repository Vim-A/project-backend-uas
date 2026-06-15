@extends('layouts.app')

@section('title', 'Detail Concert')

@section('content')
<div class="page-shell">
    <section class="hero-panel">
        <h1>{{ $concert->name }}</h1>
        <p>Detail konser, artist, ticket, dan gallery yang terhubung.</p>
    </section>

    @php
        $statusClass = $concert->status === 'finished' ? 'red' : ($concert->status === 'ongoing' ? 'yellow' : 'green');
    @endphp

    <section class="content-card">
        <div class="grid grid-2">
            <div>
                <img src="{{ asset($concert->poster_url ?? 'resource/image/logo-beatmeet.png') }}"
                     alt="{{ $concert->name }}"
                     style="width:100%;max-height:430px;object-fit:cover;border-radius:16px;background:#17223a;">
            </div>

            <div>
                <span class="badge {{ $statusClass }}">{{ ucfirst($concert->status) }}</span>
                <h2 style="margin:8px 0;">{{ $concert->name }}</h2>

                <div class="info-row">
                    <span>Artist</span>
                    <span>{{ $concert->artists->pluck('name')->implode(', ') ?: '-' }}</span>
                </div>

                <div class="info-row">
                    <span>Tanggal</span>
                    <span>{{ $concert->event_date ? $concert->event_date->format('d M Y, H:i') . ' WIB' : '-' }}</span>
                </div>

                <div class="info-row">
                    <span>Total Tipe Ticket</span>
                    <span>{{ $concert->tickets->count() }}</span>
                </div>

                <p style="line-height:1.6;margin-top:16px;">
                    {{ $concert->description ?? 'Tidak ada deskripsi.' }}
                </p>

                <div class="actions" style="margin-top:18px;">
                    <a href="{{ route('concerts.index') }}" class="btn btn-soft">Kembali</a>
                    <a href="{{ route('tickets.index') }}" class="btn btn-primary">Lihat Ticket</a>

                    <form action="{{ route('wishlist.store') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="concert_id" value="{{ $concert->id }}">
                        <button type="submit" class="btn btn-soft">♡ Wishlist</button>
                    </form>

                    @if(session('pengguna_role') === 'admin')
                        <a href="{{ route('concerts.edit', $concert->id) }}" class="btn btn-dark">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="content-card">
        <div class="section-head">
            <div>
                <h2>Ticket Concert</h2>
                <p class="muted" style="margin:6px 0 0;">Ticket yang terhubung dengan concert ini.</p>
            </div>
        </div>

        @if($concert->tickets->isEmpty())
            <div class="empty-state">Belum ada ticket untuk concert ini.</div>
        @else
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Tipe</th>
                        <th>Venue</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Harga</th>
                        <th>Stock</th>
                        <th>Aksi</th>
                    </tr>

                    @foreach($concert->tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->tipe_ticket }}</td>
                            <td>{{ $ticket->venue?->nama_venue ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($ticket->tanggal_konser)->format('d M Y') }}</td>
                            <td>{{ substr($ticket->jam_konser, 0, 5) }} WIB</td>
                            <td>Rp{{ number_format($ticket->harga, 0, ',', '.') }}</td>
                            <td>{{ $ticket->stock }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-soft">Detail</a>
                                <a href="{{ route('booking.create') }}" class="btn btn-primary">Booking</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    </section>

    @if($concert->galleries->isNotEmpty())
        <section class="content-card">
            <div class="section-head">
                <div>
                    <h2>Gallery Terkait</h2>
                    <p class="muted" style="margin:6px 0 0;">Dokumentasi visual untuk concert ini.</p>
                </div>
            </div>

            <div class="grid grid-3">
                @foreach($concert->galleries as $gallery)
                    <div class="event-card">
                        <img src="{{ asset($gallery->gambar) }}" alt="{{ $gallery->judul }}" style="width:100%;height:190px;object-fit:cover;display:block;">
                        <div style="padding:16px;">
                            <span class="badge {{ $gallery->is_featured ? 'green' : '' }}">{{ $gallery->is_featured ? 'Featured' : ucfirst($gallery->kategori) }}</span>
                            <h3 style="margin:6px 0;">{{ $gallery->judul }}</h3>
                            <a href="{{ route('gallery.show', $gallery->id) }}" class="btn btn-soft">Detail Gallery</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection