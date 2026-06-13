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