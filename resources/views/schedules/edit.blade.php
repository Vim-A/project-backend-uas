@extends('layouts.app')

@section('title', 'Edit Schedule')

@section('content')
<section class="hero-panel">
    <h1>Edit Schedule</h1>
    <p>Schedule utama mengikuti data Ticket.</p>
</section>

<section class="content-card">
    <a href="{{ route('schedule.index') }}" class="btn btn-soft">Kembali Schedule</a>
</section>
@endsection
