<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $merchandises = Merchandise::all();
    return view('merchandises.index', compact('merchandises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('merchandises.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    Merchandise::create([
        'nama_merchandise' => $request->nama_merchandise,
        'kategori' => $request->kategori,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('merchandises.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Merchandise $merchandise)
    {
    return view('merchandises.show', compact('merchandise'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Merchandise $merchandise)
    {
    return view('merchandises.edit', compact('merchandise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Merchandise $merchandise)
    {
    $merchandise->update([
            'nama_merchandise' => $request->nama_merchandise,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('merchandises.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Merchandise $merchandise)
    {
    $merchandise->delete();
        return redirect()->route('merchandises.index');
    }
}
