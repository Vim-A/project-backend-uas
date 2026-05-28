<h1>Register Pengguna</h1>

@if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<form action="{{ route('pengguna.prosesRegister') }}" method="POST">
    @csrf

    <label>Nama</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Gmail</label><br>
    <input type="email" name="gmail" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <label>NIK</label><br>
    <input type="text" name="nik" required><br><br>

    <button type="submit">Register</button>
</form>

<br>

<a href="{{ route('pengguna.login') }}">Sudah punya akun? Login</a>