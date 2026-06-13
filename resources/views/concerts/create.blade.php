@extends('layouts.app')

@section('title', 'Tambah Concert')

@section('content')
<div class="page-shell">
    <section class="hero-panel">
        <h1>Tambah Concert</h1>
        <p>Tambahkan data konser baru untuk ditampilkan di BeatMeet.</p>
    </section>

    <form action="{{ route('concerts.store') }}" method="POST" class="form-card">
        @csrf

        <div class="field">
            <label>Nama Concert</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Bruno Mars Live in Jakarta" required>
        </div>

        <div class="field">
            <label>Artist</label>
            <select name="artist_id" required>
                <option value="">Pilih artist</option>
                @foreach($artists as $artist)
                    <option value="{{ $artist->id }}" {{ old('artist_id') == $artist->id ? 'selected' : '' }}>
                        {{ $artist->name }} - {{ $artist->genre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-2">
            <div class="field">
                <label>Tanggal dan Jam</label>
                <input type="datetime-local" name="event_date" value="{{ old('event_date') }}" required>
            </div>

            <div class="field">
                <label>Status</label>
                <select name="status" required>
                    <option value="upcoming" {{ old('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="ongoing" {{ old('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="finished" {{ old('status') === 'finished' ? 'selected' : '' }}>Finished</option>
                </select>
            </div>
        </div>

        <div class="field">
            <label>Poster URL / Path Gambar</label>
            <input type="text" name="poster_url" value="{{ old('poster_url') }}" placeholder="Contoh: resource/image/bruno.jpg">
        </div>

        <div class="field">
            <label>Deskripsi</label>
            <textarea name="description" placeholder="Tulis deskripsi konser...">{{ old('description') }}</textarea>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Simpan Concert</button>
            <a href="{{ route('concerts.index') }}" class="btn btn-soft">Kembali</a>
        </div>
    </form>
</div>
@endsection