@extends('layouts.app')

@section('title', 'Schedule Konser')

@section('content')
<section class="hero-panel">
    <h1>Schedule Konser</h1>
    <p>Daftar konser BeatMeet berdasarkan data tiket, artis, dan venue.</p>
</section>

<section class="content-card">
    <div class="section-head">
        <div>
            <h2>Jadwal Tersedia</h2>
            <p class="muted" style="margin:6px 0 0;">Pilih konser yang ingin kamu pesan.</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-soft">Kembali Home</a>
    </div>

    @if($schedules->isEmpty())
        <div class="empty-state">Belum ada schedule konser.</div>
    @else
        <div class="grid grid-2">
            @foreach($schedules as $schedule)
                <div class="ticket-card">
                    <div class="ticket-head">
                        <span class="badge {{ $schedule->total_stock > 0 ? 'green' : 'red' }}">
                            {{ $schedule->total_stock > 0 ? 'Tersedia' : 'Sold Out' }}
                        </span>
                        <h3>{{ $schedule->nama_konser }}</h3>
                        <p>{{ $schedule->nama_artis }}</p>
                    </div>

                    <div class="ticket-body">
                        <div class="info-row"><span>Venue</span><span>{{ $schedule->venue?->nama_venue ?? '-' }}</span></div>
                        <div class="info-row"><span>Kota</span><span>{{ $schedule->venue?->kota ?? '-' }}</span></div>
                        <div class="info-row"><span>Tanggal</span><span>{{ \Carbon\Carbon::parse($schedule->tanggal_konser)->format('d M Y') }}</span></div>
                        <div class="info-row"><span>Jam</span><span>{{ substr($schedule->jam_konser, 0, 5) }} WIB</span></div>
                        <div class="info-row"><span>Tipe Tiket</span><span>{{ $schedule->tipe_tiket }}</span></div>
                        <div class="info-row"><span>Harga Mulai</span><span>Rp{{ number_format($schedule->harga_mulai, 0, ',', '.') }}</span></div>
                        <div class="info-row"><span>Total Stock</span><span>{{ $schedule->total_stock }}</span></div>

                        <div class="actions" style="margin-top:16px;">
                            <a href="{{ route('booking.create') }}" class="btn btn-primary">Booking</a>
                            <a href="{{ route('tickets.index') }}" class="btn btn-soft">Lihat Ticket</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
