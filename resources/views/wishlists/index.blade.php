@extends('layouts.app')

@section('title', 'Wishlist Konser')

@section('content')
<style>
    .wishlist-page {
        min-height: calc(100vh - 70px);
        background: radial-gradient(circle at center, #4b5f9a 0%, #2d3d63 45%, #17243b 100%);
        padding: 70px 0 140px;
    }

    .wishlist-wrapper {
        width: 70%;
        margin: 0 auto;
        background: white;
        border-radius: 14px;
        padding: 25px;
    }

    .wishlist-wrapper h1 {
        margin-top: 0;
        color: #111827;
    }

    .wishlist-card {
        border: 1px solid #d7def0;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 14px;
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: center;
    }

    .wishlist-card h3 {
        margin: 0 0 6px;
        color: #111827;
    }

    .wishlist-card p {
        margin: 0;
        color: #5c6680;
        font-size: 14px;
    }

    .btn-hapus {
        background: #ef4765;
        color: white;
        border: none;
        padding: 9px 14px;
        border-radius: 10px;
        cursor: pointer;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 18px;
        color: #ef4765;
        text-decoration: none;
        font-weight: bold;
    }

    .empty-text {
        color: #5c6680;
    }
</style>

<div class="wishlist-page">
    <div class="wishlist-wrapper">
        <a href="{{ route('home') }}" class="back-link">Kembali ke Home</a>

        <h1>Wishlist Konser</h1>

        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if ($wishlists->isEmpty())
            <p class="empty-text">Belum ada konser yang kamu favoritkan.</p>
        @else
            @foreach ($wishlists as $wishlist)
                <div class="wishlist-card">
                    <div>
                        <h3>{{ $wishlist->concert->name ?? '-' }}</h3>
                        <p>{{ $wishlist->concert->description ?? 'Tidak ada deskripsi.' }}</p>
                    </div>

                    <form action="{{ route('wishlist.destroy', $wishlist->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-hapus">Hapus</button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection