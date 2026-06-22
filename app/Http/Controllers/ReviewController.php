<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('ticket')
            ->orderBy('id', 'desc')
            ->get();

        return view('reviews.index', compact('reviews'));
    }

    public function create(Request $request)
    {
        $ticket = Ticket::with('venue')->findOrFail($request->ticket_id);

        return view('reviews.create', compact('ticket'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:3',
        ]);

Review::create([
    'ticket_id' => $validated['ticket_id'],
    'user_id' => session('pengguna_id'),
    'nama_reviewer' => session('pengguna_nama'),
    'rating' => $validated['rating'],
    'komentar' => $validated['komentar'],
]);

        return redirect()->route('tickets.show', $validated['ticket_id'])
            ->with('success', 'Review berhasil ditambahkan.');
    }

    public function show(Review $review)
    {
        $review->load('ticket');

        return view('reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        $review->load('ticket');

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:3',
        ]);

        $review->update($validated);

        return redirect()->route('reviews.index')
            ->with('success', 'Review berhasil diperbarui.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('reviews.index')
            ->with('success', 'Review berhasil dihapus.');
    }
}