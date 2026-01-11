<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Metrochilon</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root{--primary:#dc2626;--primary-light:#ef4444;--bg:#0a0a0f;--card:rgba(255,255,255,0.95);--text:#1f2937;--muted:#6b7280;--border:rgba(220,38,38,0.2)}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Inter, system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;min-height:100vh;background:var(--bg);color:var(--text)}
        .container{display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px}
        .card{background:var(--card);border-radius:16px;padding:28px;max-width:480px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,0.3)}
        .input{width:100%;padding:12px 14px;border:2px solid var(--border);border-radius:10px;background:rgba(255,255,255,0.9)}
        .btn{width:100%;padding:12px;background:linear-gradient(135deg,var(--primary),var(--primary-light));color:#fff;border:none;border-radius:10px;cursor:pointer}
        .hint{margin-top:12px;text-align:center;color:var(--muted)}
        .error{background:rgba(220,38,38,0.1);border:1px solid rgba(220,38,38,0.3);color:#dc2626;padding:12px;border-radius:8px;margin-bottom:12px}
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>Reset Password</h2>
            <p class="hint">Masukkan password baru untuk akun Anda.</p>

            <form method="POST" action="{{ route('password.update') }}" novalidate>
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                @if ($errors->any())
                    <div class="error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div style="margin-top:12px">
                    <input class="input" type="email" name="email" placeholder="Email" value="{{ old('email') ?? request('email') }}" required>
                </div>

                <div style="margin-top:12px">
                    <input class="input" type="password" name="password" placeholder="Password Baru" required>
                </div>

                <div style="margin-top:12px">
                    <input class="input" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
                </div>

                <div style="margin-top:14px">
                    <button type="submit" class="btn">Atur Ulang Password</button>
                </div>
            </form>

            <div class="hint" style="margin-top:14px">Kembali ke <a href="{{ route('login') }}">Masuk</a></div>
        </div>
    </div>
</body>
</html>