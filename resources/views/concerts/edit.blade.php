@extends('layouts.app')

@section('title', 'Edit Concert')

@section('content')
<div class="page-shell">
    <section class="hero-panel">
        <h1>Edit Concert</h1>
        <p>Ubah data konser yang sudah tersedia.</p>
    </section>

    <form action="{{ route('concerts.update', $concert->id) }}" method="POST" class="form-card">
        @csrf
        @method('PUT')

        <div class="field">
            <label>Nama Concert</label>
            <input type="text" name="name" value="{{ old('name', $concert->name) }}" required>
        </div>

        <div class="field">
            <label>Artist</label>
            @php
                $selectedArtist = old('artist_id', optional($concert->artists->first())->id);
            @endphp
            <select name="artist_id" required>
                <option value="">Pilih artist</option>
                @foreach($artists as $artist)
                    <option value="{{ $artist->id }}" {{ $selectedArtist == $artist->id ? 'selected' : '' }}>
                        {{ $artist->name }} - {{ $artist->genre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-2">
            <div class="field">
                <label>Tanggal dan Jam</label>
                <input type="datetime-local" name="event_date" value="{{ old('event_date', $concert->event_date ? $concert->event_date->format('Y-m-d\\TH:i') : '') }}" required>
            </div>

            <div class="field">
                <label>Status</label>
                <select name="status" required>
                    <option value="upcoming" {{ old('status', $concert->status) === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="ongoing" {{ old('status', $concert->status) === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="finished" {{ old('status', $concert->status) === 'finished' ? 'selected' : '' }}>Finished</option>
                </select>
            </div>
        </div>

        <div class="field">
            <label>Poster URL / Path Gambar</label>
            <input type="text" name="poster_url" value="{{ old('poster_url', $concert->poster_url) }}" placeholder="Contoh: resource/image/bruno.jpg">
        </div>

        <div class="field">
            <label>Deskripsi</label>
            <textarea name="description">{{ old('description', $concert->description) }}</textarea>
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Update Concert</button>
            <a href="{{ route('concerts.index') }}" class="btn btn-soft">Kembali</a>
        </div>
    </form>
</div>
@endsection
