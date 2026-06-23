@extends('layouts.app')

@section('title', 'Daftar Venue — BeatMeet')

@section('content')
<div class="page-shell">

    <div class="section-head">
        <div>
            <h2>Venue</h2>
            <p class="muted small" style="margin:4px 0 0;">{{ $venues->count() }} venue terdaftar</p>
        </div>
        <a href="{{ route('venues.create') }}" class="btn btn-primary">+ Tambah Venue</a>
    </div>

    <div class="content-card" style="padding: 16px 24px;">
        <div class="actions" style="margin-bottom: 14px;">
            <span class="muted small">Urutkan kapasitas:</span>
            <a href="{{ route('venues.index', ['sort' => 'asc']) }}"
               class="btn {{ $sort === 'asc' ? 'btn-primary' : '' }}" style="padding:7px 14px; font-size:14px;">
                ↑ Terkecil
            </a>
            <a href="{{ route('venues.index', ['sort' => 'desc']) }}"
               class="btn {{ $sort === 'desc' ? 'btn-primary' : '' }}" style="padding:7px 14px; font-size:14px;">
                ↓ Terbesar
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:44px">#</th>
                    <th>Nama Venue</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th style="width:140px; text-align:center;">Kapasitas</th>
                    <th style="width:140px; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($venues as $index => $venue)
                    <tr>
                        <td class="muted small">{{ $index + 1 }}</td>
                        <td style="font-weight:bold;">{{ $venue->nama_venue }}</td>
                        <td class="muted small">{{ $venue->alamat }}</td>
                        <td>
                            <span class="badge">{{ $venue->kota }}</span>
                        </td>
                        <td style="text-align:center;">
                            <span class="badge green">{{ number_format($venue->kapasitas) }} orang</span>
                        </td>
                        <td>
                            <div class="actions" style="justify-content:center; gap:6px;">
                                <a href="{{ route('venues.show', $venue->id) }}"
                                   class="btn btn-soft" style="padding:6px 12px; font-size:13px;">
                                    Lihat
                                </a>
                                <a href="{{ route('venues.edit', $venue->id) }}"
                                   class="btn" style="padding:6px 12px; font-size:13px;">
                                    Edit
                                </a>
                                <form action="{{ route('venues.destroy', $venue->id) }}"
                                      method="POST" style="display:inline;"
                                      onsubmit="return confirm('Yakin hapus venue ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger" style="padding:6px 12px; font-size:13px;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state" style="text-align:center;">
                                <p class="muted">Belum ada venue.
                                    <a href="{{ route('venues.create') }}" style="color:var(--pink);">Tambah sekarang</a>
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection