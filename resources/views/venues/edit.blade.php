@extends('layouts.app')

@section('title', 'Edit Venue — BeatMeet')

@section('content')
<div class="page-shell">

    {{-- Breadcrumb --}}
    <p class="muted small" style="margin:0 0 14px;">
        <a href="{{ route('venues.index') }}" style="color:var(--pink); text-decoration:none;">Venue</a>
        &rsaquo;
        <a href="{{ route('venues.show', $venue->id) }}" style="color:var(--pink); text-decoration:none;">{{ $venue->nama_venue }}</a>
        &rsaquo; Edit
    </p>

    <div class="form-card" style="max-width: 580px;">

        <h2 style="margin:0 0 20px;">Edit Venue</h2>

        <form action="{{ route('venues.update', $venue->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="nama_venue">
                    Nama Venue <span style="color:var(--pink);">*</span>
                </label>
                <input type="text"
                       id="nama_venue"
                       name="nama_venue"
                       value="{{ old('nama_venue', $venue->nama_venue) }}"
                       placeholder="Contoh: Gedung Serbaguna A">
                @error('nama_venue')
                    <p class="small" style="color:#dc2626; margin:4px 0 0;">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="alamat">
                    Alamat <span style="color:var(--pink);">*</span>
                </label>
                <textarea id="alamat"
                          name="alamat"
                          placeholder="Masukkan alamat lengkap venue">{{ old('alamat', $venue->alamat) }}</textarea>
                @error('alamat')
                    <p class="small" style="color:#dc2626; margin:4px 0 0;">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-2" style="gap:16px;">
                <div class="field" style="margin-bottom:0;">
                    <label for="kota">
                        Kota <span style="color:var(--pink);">*</span>
                    </label>
                    <input type="text"
                           id="kota"
                           name="kota"
                           value="{{ old('kota', $venue->kota) }}"
                           placeholder="Contoh: Yogyakarta">
                    @error('kota')
                        <p class="small" style="color:#dc2626; margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field" style="margin-bottom:0;">
                    <label for="kapasitas">
                        Kapasitas <span style="color:var(--pink);">*</span>
                    </label>
                    <div style="display:flex;">
                        <input type="number"
                               id="kapasitas"
                               name="kapasitas"
                               value="{{ old('kapasitas', $venue->kapasitas) }}"
                               min="1"
                               placeholder="500"
                               style="border-radius:9px 0 0 9px; border-right:none;">
                        <span style="
                            display:flex; align-items:center;
                            padding:0 14px;
                            background:#f2f4f7;
                            border:1.5px solid #344056;
                            border-left:none;
                            border-radius:0 9px 9px 0;
                            color:var(--muted);
                            font-size:15px;
                            white-space:nowrap;
                        ">orang</span>
                    </div>
                    @error('kapasitas')
                        <p class="small" style="color:#dc2626; margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="actions" style="margin-top:24px; padding-top:16px; border-top:1px solid var(--line);">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('venues.show', $venue->id) }}" class="btn">Batal</a>
            </div>

        </form>
    </div>

</div>
@endsection