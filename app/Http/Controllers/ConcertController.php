<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Concert;
use Illuminate\Http\Request;

class ConcertController extends Controller
{
    public function index()
    {
        $concerts = Concert::with(['artists', 'tickets.venue'])
            ->orderBy('event_date')
            ->get();

        return view('concerts.index', compact('concerts'));
    }

    public function create()
    {
        if (session('pengguna_role') !== 'admin') {
            return redirect()->route('concerts.index')->with('error', 'Akses hanya untuk admin.');
        }

        $artists = Artist::orderBy('name')->get();

        return view('concerts.create', compact('artists'));
    }

    public function store(Request $request)
    {
        if (session('pengguna_role') !== 'admin') {
            return redirect()->route('concerts.index')->with('error', 'Akses hanya untuk admin.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'artist_id'   => 'required|exists:artists,id',
            'event_date'  => 'required|date',
            'description' => 'nullable|string',
            'poster_url'  => 'nullable|string|max:255',
            'status'      => 'required|in:upcoming,ongoing,finished',
        ]);

        $concert = Concert::create([
            'name'        => $request->name,
            'description' => $request->description,
            'poster_url'  => $request->poster_url,
            'event_date'  => $request->event_date,
            'status'      => $request->status,
        ]);

        $concert->artists()->sync([$request->artist_id]);

        return redirect()->route('concerts.index')->with('success', 'Data konser berhasil ditambahkan.');
    }

    public function show($id)
    {
        $concert = Concert::with(['artists', 'tickets.venue', 'galleries'])
            ->findOrFail($id);

        return view('concerts.show', compact('concert'));
    }

    public function edit($id)
    {
        if (session('pengguna_role') !== 'admin') {
            return redirect()->route('concerts.index')->with('error', 'Akses hanya untuk admin.');
        }

        $concert = Concert::with('artists')->findOrFail($id);
        $artists = Artist::orderBy('name')->get();

        return view('concerts.edit', compact('concert', 'artists'));
    }

    public function update(Request $request, $id)
    {
        if (session('pengguna_role') !== 'admin') {
            return redirect()->route('concerts.index')->with('error', 'Akses hanya untuk admin.');
        }

        $concert = Concert::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'artist_id'   => 'required|exists:artists,id',
            'event_date'  => 'required|date',
            'description' => 'nullable|string',
            'poster_url'  => 'nullable|string|max:255',
            'status'      => 'required|in:upcoming,ongoing,finished',
        ]);

        $concert->update([
            'name'        => $request->name,
            'description' => $request->description,
            'poster_url'  => $request->poster_url,
            'event_date'  => $request->event_date,
            'status'      => $request->status,
        ]);

        $concert->artists()->sync([$request->artist_id]);

        return redirect()->route('concerts.index')->with('success', 'Data konser berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (session('pengguna_role') !== 'admin') {
            return redirect()->route('concerts.index')->with('error', 'Akses hanya untuk admin.');
        }

        $concert = Concert::findOrFail($id);
        $concert->delete();

        return redirect()->route('concerts.index')->with('success', 'Data konser berhasil dihapus.');
    }
}
