<h1>Detail Payment</h1>

<p>Booking ID: {{ $payment->booking_id }}</p>
<p>Jumlah Bayar: Rp{{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
<p>Metode Pembayaran: {{ $payment->metode_pembayaran }}</p>
<p>Status: {{ $payment->status }}</p>

<a href="/payments">Kembali</a>