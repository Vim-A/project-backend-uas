<h1>Login Pengguna</h1>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<form action="{{ route('pengguna.prosesLogin') }}" method="POST">
    @csrf

    <label>Gmail</label><br>
    <input type="email" name="gmail" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

<br>

<a href="{{ route('pengguna.register') }}">Belum punya akun? Register</a><br>
<a href="{{ route('pengguna.forgotPassword') }}">Lupa Password?</a> 