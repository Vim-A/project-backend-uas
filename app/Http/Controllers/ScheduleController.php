<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Ticket::with(['concert.artists', 'venue'])
            ->orderBy('tanggal_konser')
            ->orderBy('jam_konser')
            ->get()
            ->groupBy(function ($ticket) {
                return $ticket->concert_id . '-' .
                       $ticket->venue_id . '-' .
                       $ticket->tanggal_konser . '-' .
                       $ticket->jam_konser;
            })
            ->map(function ($group) {
                $jadwal = $group->first();

                $jadwal->tipe_tiket = $group->pluck('tipe_ticket')->implode(', ');
                $jadwal->harga_mulai = $group->min('harga');
                $jadwal->total_stock = $group->sum('stock');

                return $jadwal;
            })
            ->values();

        return view('schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}