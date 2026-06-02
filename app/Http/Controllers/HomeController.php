<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use App\Models\Gallery;
use App\Models\Ticket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $concerts = Concert::with('artists')
            ->orderBy('event_date')
            ->get();

        $highlight = Concert::with('artists')
            ->where('name', 'like', '%Bruno Mars%')
            ->first();

        $tickets = Ticket::with(['concert.artists', 'venue'])
            ->orderBy('tanggal_konser')
            ->orderBy('jam_konser')
            ->take(6)
            ->get();

        $galleryPreview = Gallery::with('concert')
            ->where('is_featured', true)
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact('concerts', 'highlight', 'tickets', 'galleryPreview'));
    }
}
