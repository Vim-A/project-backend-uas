<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BeatMeet')</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --pink: #ef4765;
            --pink-dark: #db3152;
            --navy: #17223a;
            --navy-2: #223050;
            --blue: #54649d;
            --light: #f7f7f8;
            --line: #d9dee8;
            --text: #111827;
            --muted: #667085;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #ffffff;
            color: var(--text);
        }

        a { color: inherit; }

        .beatmeet-page {
            width: 100%;
            min-height: 100vh;
            background: radial-gradient(circle at 55% 48%, #596aa6 0%, #314367 42%, #17223a 100%);
        }

        .navbar {
            background: var(--pink);
            min-height: 76px;
            padding: 10px 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #233456;
        }

        .navbar-logo img {
            width: 72px;
            height: auto;
            display: block;
            border-radius: 10px;
            background: #fff6df;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 27px;
            font-size: 22px;
        }

        .navbar-menu a,
        .logout-link {
            text-decoration: none;
            color: #050505;
            border: none;
            background: transparent;
            font: inherit;
            cursor: pointer;
            padding: 0;
        }

        .navbar-menu a:hover,
        .logout-link:hover { text-decoration: underline; }

        .login-pill {
            background: #1d2a45 !important;
            color: white !important;
            padding: 11px 18px !important;
            border-radius: 17px;
            text-decoration: none !important;
        }

        .main-content {
            min-height: calc(100vh - 76px);
        }

        .page-shell {
            max-width: 1180px;
            margin: 0 auto;
            padding: 34px 26px 60px;
        }

        .hero-panel {
            background: rgba(15, 23, 42, 0.62);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            padding: 26px;
            margin-bottom: 24px;
        }

        .hero-panel h1 {
            margin: 0 0 8px;
            font-size: 36px;
        }

        .hero-panel p {
            margin: 0;
            color: #e5ecff;
            line-height: 1.5;
        }

        .content-card,
        .form-card {
            background: rgba(255,255,255,0.96);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .section-head h2,
        .content-card h2 {
            margin: 0;
            font-size: 25px;
        }

        .muted { color: var(--muted); }
        .small { font-size: 14px; }

        .grid { display: grid; gap: 18px; }
        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }

        .btn,
        button.btn {
            display: inline-block;
            border: 1px solid #cbd5e1;
            padding: 10px 15px;
            border-radius: 12px;
            text-decoration: none;
            background: white;
            color: #0f172a;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-primary {
            background: var(--pink);
            border-color: var(--pink);
            color: white;
        }

        .btn-primary:hover { background: var(--pink-dark); }

        .btn-dark {
            background: #1d2a45;
            border-color: #1d2a45;
            color: white;
        }

        .btn-soft {
            background: #eef2ff;
            border-color: #c7d2fe;
            color: #1d2a45;
        }

        .btn-danger {
            background: #dc2626;
            border-color: #dc2626;
            color: white;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 16px;
            border: 1px solid transparent;
        }

        .alert-success {
            background: #dcfce7;
            border-color: #86efac;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .field { margin-bottom: 16px; }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1.5px solid #344056;
            border-radius: 9px;
            font-size: 15px;
            background: white;
        }

        textarea { min-height: 110px; }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            padding: 13px 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #1d2a45;
            color: white;
        }

        .badge {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 999px;
            border: 1px solid #d0d5dd;
            background: #f2f4f7;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .badge.green { background: #dcfce7; color: #166534; border-color: #86efac; }
        .badge.yellow { background: #fef3c7; color: #92400e; border-color: #facc15; }
        .badge.red { background: #fee2e2; color: #991b1b; border-color: #fecaca; }

        .ticket-card,
        .event-card {
            background: white;
            border: 1px solid var(--line);
            border-radius: 18px;
            overflow: hidden;
        }

        .ticket-head {
            background: #1d2a45;
            color: white;
            padding: 18px;
        }

        .ticket-head h3 { margin: 8px 0 4px; }
        .ticket-body { padding: 18px; }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 1px solid #e5e7eb;
            padding: 9px 0;
        }

        .empty-state {
            padding: 20px;
            border: 1px solid var(--line);
            background: #fafafa;
            border-radius: 14px;
        }

        .auth-page {
            min-height: calc(100vh - 76px);
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .auth-card {
            width: 420px;
            max-width: 100%;
            background: #fbfbfd;
            border-radius: 22px;
            padding: 54px 34px 38px;
            border: 1px solid rgba(255,255,255,0.7);
            box-shadow: 0 18px 45px rgba(0,0,0,0.25);
            position: relative;
            z-index: 2;
        }

        .auth-card h1 {
            margin: 0 0 6px;
            text-align: center;
            font-size: 46px;
            line-height: .95;
            letter-spacing: -2px;
            color: black;
        }

        .auth-card .welcome {
            text-align: center;
            margin: 0;
            font-size: 22px;
            color: black;
        }

        .auth-card .auth-note {
            text-align: center;
            margin: 8px 0 30px;
            color: var(--muted);
            font-size: 14px;
        }

        .auth-submit {
            display: flex;
            justify-content: flex-end;
            margin-top: -4px;
        }

        .auth-links {
            margin-top: 10px;
            font-size: 12px;
        }

        .auth-links a {
            color: #5b86d9;
            display: block;
            margin-bottom: 5px;
        }

        .disc-row {
            position: absolute;
            bottom: -70px;
            left: 0;
            right: 0;
            height: 170px;
            z-index: 1;
            pointer-events: none;
        }

        .disc {
            position: absolute;
            bottom: 0;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: radial-gradient(circle at center, #111 0 11%, white 12% 17%, #ef4765 18% 22%, #e97a2c 23% 45%, #2b334e 46% 100%);
            opacity: .86;
            border: 1px solid rgba(255,255,255,.4);
        }

        .disc:nth-child(1) { left: 18px; transform: scale(.75); }
        .disc:nth-child(2) { left: 95px; transform: scale(.9); background: radial-gradient(circle at center, #111 0 11%, white 12% 17%, #3b82f6 18% 22%, #ef4765 23% 52%, #19223b 53% 100%); }
        .disc:nth-child(3) { left: 210px; transform: scale(1.15); background: radial-gradient(circle at center, #111 0 11%, white 12% 17%, #fbbf24 18% 22%, #d1d5db 23% 52%, #fff 53% 100%); }
        .disc:nth-child(4) { right: 260px; transform: scale(.95); background: radial-gradient(circle at center, #111 0 11%, white 12% 17%, #facc15 18% 22%, #7c9b6f 23% 52%, #9c7b72 53% 100%); }
        .disc:nth-child(5) { right: 130px; transform: scale(.86); background: radial-gradient(circle at center, #111 0 11%, white 12% 17%, #f97316 18% 22%, #a77b4d 23% 52%, #506b7e 53% 100%); }
        .disc:nth-child(6) { right: 30px; transform: scale(.7); background: radial-gradient(circle at center, #111 0 11%, white 12% 17%, #60a5fa 18% 22%, #b56553 23% 52%, #40526d 53% 100%); }

        @media (max-width: 900px) {
            .navbar { padding: 12px 18px; flex-direction: column; gap: 10px; }
            .navbar-menu { gap: 13px; flex-wrap: wrap; justify-content: center; font-size: 16px; }
            .page-shell { padding: 22px 14px 50px; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .section-head { flex-direction: column; align-items: flex-start; }
            .auth-page { padding-top: 28px; }
        }
    </style>
</head>
<body>
    <div class="beatmeet-page">
        @hasSection('hide_nav')
        @else
        <nav class="navbar">
            <div class="navbar-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('resource/image/logo-beatmeet.png') }}" alt="BeatMeet Logo">
                </a>
            </div>

            <div class="navbar-menu">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('concerts.index') }}">Concert</a>
                <a href="{{ route('schedule.index') }}">Schedule</a>
                <a href="{{ route('tickets.index') }}">Ticket</a>
                <a href="{{ route('booking.index') }}">Booking</a>
                <a href="{{ route('riwayat.index') }}">History</a>
                <a href="{{ route('wishlist.index') }}">Wishlist</a>
                @if(session('pengguna_role') === 'admin')
                    <a href="{{ route('venues.index') }}">Venue</a>
                    <a href="{{ route('booking-refund.index') }}">Refund</a>
                @endif
                <a href="{{ route('gallery.index') }}">Gallery</a>

                @if(session('pengguna_id'))
                    <form action="{{ route('pengguna.logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="logout-link login-pill">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('pengguna.login') }}" class="login-pill">Log In</a>
                @endif
            </div>
        </nav>
        @endif

        <main class="main-content">
            @if(session('success'))
                <div class="page-shell" style="padding-bottom:0;">
                    <div class="alert alert-success">{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="page-shell" style="padding-bottom:0;">
                    <div class="alert alert-error">{{ session('error') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="page-shell" style="padding-bottom:0;">
                    <div class="alert alert-error">
                        <ul style="margin:0; padding-left:18px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @include('customer_service.chat-widget')
</body>
</html>
