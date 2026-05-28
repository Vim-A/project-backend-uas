<h1>Forgot Password</h1>

@if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<form action="{{ route('pengguna.prosesForgotPassword') }}" method="POST">
    @csrf

    <label>Gmail</label><br>
    <input type="email" name="gmail" required><br><br>

    <label>NIK</label><br>
    <input type="text" name="nik" required><br><br>

    <label>Password Baru</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Ubah Password</button>
</form>

<br>

<a href="{{ route('pengguna.login') }}">Kembali ke Login</a>