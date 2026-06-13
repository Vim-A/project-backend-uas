@extends('layouts.app')

@section('title', 'Detail Schedule')

@section('content')
<section class="hero-panel">
    <h1>Detail Schedule</h1>
    <p>Detail schedule dapat dilihat melalui halaman Ticket.</p>
</section>

<section class="content-card">
    <a href="{{ route('schedule.index') }}" class="btn btn-soft">Kembali Schedule</a>
    <a href="{{ route('tickets.index') }}" class="btn btn-primary">Lihat Ticket</a>
</section>
@endsection
