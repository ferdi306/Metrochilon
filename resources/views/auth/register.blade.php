<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Metrochilon</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #dc2626;
            --primary-light: #ef4444;
            --bg: #0a0a0f;
            --card: rgba(255, 255, 255, 0.95);
            --text: #1f2937;
            --muted: #6b7280;
            --border: rgba(220, 38, 38, 0.2);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; min-height: 100vh; background: var(--bg); color: var(--text); }
        .register-container { display:flex; align-items:center; justify-content:center; min-height:100vh; padding:24px; }
        .register-card { background:var(--card); border-radius:20px; padding:36px; max-width:520px; width:100%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .logo { text-align:center; margin-bottom:20px; }
        .form-group { margin-bottom:14px; }
        .input { width:100%; padding:12px 14px; border:2px solid var(--border); border-radius:10px; background:rgba(255,255,255,0.9); }
        .btn-submit { width:100%; padding:12px; background:linear-gradient(135deg, var(--primary), var(--primary-light)); color:#fff; border:none; border-radius:10px; font-weight:600; cursor:pointer; }
        .hint { margin-top:12px; font-size:13px; color:var(--muted); text-align:center; }
        .error-message { background: rgba(220, 38, 38, 0.1); border: 1px solid rgba(220, 38, 38, 0.3); color: #dc2626; padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="logo">
                <h1>Daftar Karyawan</h1>
                <p>Isi data untuk membuat akun karyawan</p>
            </div>

            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="form-group">
                    <input class="input" type="text" name="name" placeholder="Nama lengkap" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <input class="input" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <input class="input" id="password" type="password" name="password" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <input class="input" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
                </div>

                <div class="form-group">
                    <input class="input" type="text" name="employee_id" placeholder="ID Karyawan (opsional)" value="{{ old('employee_id') }}">
                </div>

                <div class="form-group">
                    <input class="input" type="text" name="phone" placeholder="Telepon (opsional)" value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <input class="input" type="text" name="address" placeholder="Alamat (opsional)" value="{{ old('address') }}">
                </div>

                <button type="submit" class="btn-submit">Daftar</button>
            </form>

            <div class="hint">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
            </div>
        </div>
    </div>
</body>
</html>