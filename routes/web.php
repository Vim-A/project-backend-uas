<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CustomerServiceController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tickets', TicketController::class);
Route::resource('booking', BookingController::class);
Route::resource('pengguna', PenggunaController::class);
Route::resource('schedule', ScheduleController::class);
Route::resource('customer-service', CustomerServiceController::class);
?>