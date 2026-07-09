<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="ISEKI Feed TV - Login Admin" />
    <title>Login — Innovation Feed</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700&display=swap" rel="stylesheet">

    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap.bundle.min.css') }}" rel="stylesheet" />

    <script src="/iseki_pro_app/js/dynamic-favicon.js"></script>
    <script>document.addEventListener("DOMContentLoaded", function() { setDynamicFavicon("photo_frame", "Innovation"); });</script>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fbefef 0%, #f5cece 35%, #d19fa0 70%, #b58081 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        /* --- Ambient floating blobs --- */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            pointer-events: none;
            z-index: 0;
        }
        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #fffbfb, transparent);
            top: -120px; left: -120px;
        }
        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #d19fa0, transparent);
            bottom: -100px; right: -100px;
        }

        /* --- Login Card --- */
        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            animation: cardIn 0.6s cubic-bezier(.165,.84,.44,1) both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .login-card {
            background: rgba(255, 251, 251, 0.97);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(214, 202, 202, 0.4);
            border-radius: 1.75rem;
            box-shadow: 0 24px 64px rgba(103, 93, 93, 0.2), 0 4px 16px rgba(103, 93, 93, 0.08);
            overflow: hidden;
        }

        .card-top-bar {
            height: 5px;
            background: linear-gradient(90deg, #d19fa0, #f5cece, #d19fa0);
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }
        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .card-body-inner { padding: 2.5rem 2.5rem 2rem; }

        /* Logo circle */
        .login-logo-ring {
            width: 72px; height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fbefef, #d19fa0);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 8px 24px rgba(209, 159, 160, 0.4);
            font-size: 1.8rem;
            color: #fffbfb;
            animation: pulse 3s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { box-shadow: 0 8px 24px rgba(209,159,160,0.4); }
            50%       { box-shadow: 0 12px 36px rgba(209,159,160,0.65); }
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.65rem;
            font-weight: 700;
            color: #675d5d;
            text-align: center;
            margin-bottom: 0.25rem;
        }
        .card-subtitle {
            text-align: center;
            color: #a08d8d;
            font-size: 0.875rem;
            margin-bottom: 1.75rem;
        }

        /* Divider */
        .divider-rose {
            height: 1.5px;
            background: linear-gradient(90deg, transparent, #d19fa0, transparent);
            margin: 0 auto 1.75rem;
            width: 80px;
            border: none;
        }

        /* Input group */
        .field-group { margin-bottom: 1.1rem; }
        .field-label {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: #8a7676;
            margin-bottom: 0.4rem;
            display: block;
        }
        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            color: #d19fa0;
            font-size: 1rem;
            pointer-events: none;
            z-index: 2;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1.5px solid #d6caca;
            border-radius: 0.875rem;
            background: #fffbfb;
            color: #675d5d;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
            outline: none;
        }
        .form-input::placeholder { color: #c4b4b4; }
        .form-input:focus {
            border-color: #d19fa0;
            box-shadow: 0 0 0 3.5px rgba(209, 159, 160, 0.2);
            background: #fff;
        }

        /* Error state */
        .alert-login {
            background: #fff5f5;
            border: 1px solid #f5cece;
            border-left: 4px solid #d19fa0;
            border-radius: 0.75rem;
            padding: 0.7rem 1rem;
            color: #8a5050;
            font-size: 0.82rem;
            margin-bottom: 1.25rem;
        }

        /* Submit button */
        .btn-login {
            display: block;
            width: 100%;
            padding: 0.8rem 1.5rem;
            margin-top: 1.5rem;
            border: none;
            border-radius: 2rem;
            background: linear-gradient(135deg, #d19fa0, #b58081);
            color: #fffbfb;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.4px;
            cursor: pointer;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
            box-shadow: 0 6px 20px rgba(181, 128, 129, 0.4);
            position: relative;
            overflow: hidden;
        }
        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.25s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(181, 128, 129, 0.5);
            background: linear-gradient(135deg, #b58081, #9a6d6d);
        }
        .btn-login:hover::after { opacity: 1; }
        .btn-login:active { transform: translateY(0); }
        .btn-login i { margin-right: 0.4rem; }

        /* Back link */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #a08d8d;
            font-size: 0.82rem;
            text-decoration: none;
            transition: color 0.2s;
        }
        .back-link:hover { color: #d19fa0; }
        .back-link i { font-size: 0.75rem; }

        /* Footer copyright */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: rgba(255, 251, 251, 0.65);
            font-size: 0.75rem;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="card-top-bar"></div>
            <div class="card-body-inner">

                <div class="login-logo-ring">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>

                <h1 class="card-title">Welcome Back</h1>
                <p class="card-subtitle">Silakan login untuk mengakses dashboard</p>
                <hr class="divider-rose">

                @if ($errors->any())
                    <div class="alert-login">
                        <i class="bi bi-exclamation-circle me-1"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login_process') }}">
                    @csrf

                    <div class="field-group">
                        <label class="field-label" for="username">Username</label>
                        <div class="input-wrap">
                            <i class="bi bi-person-fill input-icon"></i>
                            <input class="form-input" id="username" name="Username_User" type="text"
                                placeholder="Masukkan username..." required autofocus />
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="password">Password</label>
                        <div class="input-wrap">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input class="form-input" id="password" name="Password_User" type="password"
                                placeholder="Masukkan password..." required />
                        </div>
                    </div>

                    <button class="btn-login" type="submit">
                        <i class="bi bi-box-arrow-in-right"></i>Login
                    </button>
                </form>

                <a href="{{ route('home') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i> Kembali ke halaman utama
                </a>
            </div>
        </div>

        <p class="login-footer">
            &copy; <script>document.write(new Date().getFullYear())</script> PT. Iseki Indonesia
        </p>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>