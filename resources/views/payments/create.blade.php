<h1>Tambah Payment</h1>

<form action="/payments" method="POST">
    @csrf

    <select name="booking_id">
        @foreach($bookings as $booking)
            <option value="{{ $booking->id }}">
                Booking #{{ $booking->id }} -
                {{ $booking->ticket->nama_konser }} -
                Rp{{ number_format($booking->total_harga, 0, ',', '.') }}
            </option>
        @endforeach
    </select>
    <br><br>
    <select name="metode_pembayaran">
        <option value="transfer">Transfer Bank</option>
        <option value="kartu_kredit">Kartu Kredit</option>
        <option value="e_wallet">E-Wallet</option>
    </select>
    <br><br>
    <button type="submit">Simpan</button>
</form>