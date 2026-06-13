@extends('layouts.app')

@section('title', 'Tambah Schedule')

@section('content')
<section class="hero-panel">
    <h1>Tambah Schedule</h1>
    <p>Schedule utama diambil dari data Ticket. Gunakan halaman Ticket untuk menambah jadwal.</p>
</section>

<section class="content-card">
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">Tambah Ticket</a>
    <a href="{{ route('schedule.index') }}" class="btn btn-soft">Kembali Schedule</a>
</section>
@endsection
