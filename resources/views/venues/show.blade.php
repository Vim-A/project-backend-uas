@extends('layouts.app')

@section('title', $venue->nama_venue . ' — BeatMeet')

@section('content')
<div class="page-shell">

    {{-- Breadcrumb --}}
    <p class="muted small" style="margin:0 0 14px;">
        <a href="{{ route('venues.index') }}" style="color:var(--pink); text-decoration:none;">Venue</a>
        &rsaquo; {{ $venue->nama_venue }}
    </p>

    <div class="content-card" style="max-width: 640px;">

        <div class="section-head" style="margin-bottom:20px;">
            <h2 style="margin:0;">{{ $venue->nama_venue }}</h2>
            <div class="actions">
                <a href="{{ route('venues.edit', $venue->id) }}" class="btn">Edit</a>
                <form action="{{ route('venues.destroy', $venue->id) }}"
                      method="POST" style="display:inline;"
                      onsubmit="return confirm('Yakin hapus venue ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>

        <div class="info-row">
            <span class="muted small" style="min-width:120px;">Nama Venue</span>
            <span style="font-weight:bold; flex:1;">{{ $venue->nama_venue }}</span>
        </div>

        <div class="info-row">
            <span class="muted small" style="min-width:120px;">Alamat</span>
            <span style="flex:1;">{{ $venue->alamat }}</span>
        </div>

        <div class="info-row">
            <span class="muted small" style="min-width:120px;">Kota</span>
            <span style="flex:1;">
                <span class="badge">{{ $venue->kota }}</span>
            </span>
        </div>

        <div class="info-row" style="border-bottom:none;">
            <span class="muted small" style="min-width:120px;">Kapasitas</span>
            <span style="flex:1;">
                <span class="badge green">{{ number_format($venue->kapasitas) }} orang</span>
            </span>
        </div>

        <div style="margin-top:24px; padding-top:16px; border-top:1px solid var(--line);">
            <a href="{{ route('venues.index') }}" class="btn btn-soft">
                &larr; Kembali ke Daftar
            </a>
        </div>

    </div>

</div>
@endsection