<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Absensi - Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{ --bg:#f8fafc; --panel:#ffffff; --text:#1f2937; --muted:#6b7280; --primary:#0066ff; --primary-dark:#0052cc; --primary-light:#e6f2ff; --accent:#00b8d4; --accent-light:#e0f7fa; --success:#10b981; --warn:#f59e0b; }
        *{ box-sizing:border-box; }
        body{ margin:0; background: linear-gradient(-45deg, #f8fafc, #e6f2ff, #e0f7fa, #f0f9ff, #f8fafc); background-size: 400% 400%; animation: gradientShift 15s ease infinite; color:var(--text); font-family:'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto; position: relative; }
        @@keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(0, 102, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(0, 184, 212, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(0, 102, 255, 0.05) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }
        @@keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 1; }
            33% { transform: translate(30px, -30px) scale(1.1); opacity: 0.9; }
            66% { transform: translate(-20px, 20px) scale(0.9); opacity: 0.95; }
        }
        .shell {
            position: relative;
            z-index: 1;
        }
        .shell{ min-height:100vh; display:flex; flex-direction:column; }
        .topbar{ display:flex; align-items:center; justify-content:space-between; padding:18px 28px; background:linear-gradient(180deg, rgba(255,255,255,.95), rgba(255,255,255,.9)); backdrop-filter: blur(12px); border-bottom:2px solid var(--primary-light); position:sticky; top:0; z-index:10; box-shadow: 0 2px 10px rgba(0,102,255,.05); }
        .brand{ display:flex; align-items:center; gap:12px; font-weight:700; letter-spacing:.3px; }
        .brand .logo-text{ font-size:20px; background: linear-gradient(135deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .logout{ background:#fff; color:var(--primary); border:2px solid var(--primary); padding:10px 20px; border-radius:10px; cursor:pointer; font-weight:600; transition: all .3s ease; }
        .logout:hover{ background:var(--primary); color:#fff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,102,255,.3); }
        .main-wrapper{ display:flex; flex:1; position: relative; z-index: 1; }
        .sidebar{ width:280px; background:var(--panel); border-right:2px solid var(--primary-light); padding:24px 0; position:sticky; top:0; height:calc(100vh - 80px); overflow-y:auto; box-shadow: 2px 0 10px rgba(0,102,255,.05); z-index: 2; }
        .sidebar-header{ padding:0 24px 24px; border-bottom:2px solid var(--primary-light); margin-bottom:24px; }
        .sidebar-user{ display:flex; align-items:center; gap:12px; margin-bottom:16px; }
        .sidebar-user .avatar{ width:48px; height:48px; font-size:20px; border-radius:12px; background:linear-gradient(135deg, var(--primary), var(--accent)); display:grid; place-items:center; color:#fff; font-weight:800; }
        .sidebar-user-info h4{ margin:0; font-size:16px; font-weight:700; color:var(--text); }
        .sidebar-user-info small{ color:var(--muted); font-size:12px; }
        .sidebar-nav{ padding:0 16px; }
        .nav-item{ display:flex; align-items:center; gap:12px; padding:14px 16px; margin-bottom:8px; border-radius:12px; color:var(--text); text-decoration:none; font-weight:600; font-size:14px; transition: all .3s ease; cursor:pointer; }
        .nav-item:hover{ background:var(--primary-light); color:var(--primary); transform: translateX(4px); }
        .nav-item.active{ background:linear-gradient(135deg, var(--primary), var(--accent)); color:#fff; box-shadow: 0 4px 12px rgba(0,102,255,.3); }
        .content-wrapper{ flex:1; padding:32px; overflow-x:hidden; position: relative; z-index: 1; }
        .card{ background:var(--panel); border:1px solid rgba(0,102,255,.1); border-radius:20px; box-shadow:0 10px 30px rgba(0,102,255,.1); margin-bottom:24px; transition: all 0.3s ease; position: relative; z-index: 1; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 15px 40px rgba(0,102,255,.15); }
        .card.pad{ padding:24px; }
        .hero{ display:flex; align-items:center; justify-content:space-between; gap:18px; padding:24px; border-bottom:2px solid var(--primary-light); background: linear-gradient(135deg, rgba(0,102,255,.02), rgba(0,184,212,.02)); }
        .hero h3{ margin:0; font-size:20px; font-weight:700; color:#1f2937; }
        .hero small{ color:var(--muted); font-size:13px; }
        .form-grid{ display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .field{ display:block; margin-bottom:20px; }
        label.txt{ display:block; color:var(--muted); font-size:13px; margin-bottom:10px; letter-spacing:.2px; font-weight:600; }
        input[type=text],input[type=time],input[type=number],select{ width:100%; height:50px; padding:12px 16px; background:#fff; color:var(--text); border:2px solid #e5e7eb; border-radius:12px; font-size:14px; transition: all .3s ease; }
        input:focus,select:focus{ outline:none; border-color:var(--primary); box-shadow:0 0 0 6px rgba(0,102,255,.1); }
        .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:14px 24px; border:none; border-radius:12px; cursor:pointer; font-weight:600; letter-spacing:.3px; font-size:14px; transition: all .3s ease; }
        .btn.primary{ background:linear-gradient(135deg, var(--primary), var(--accent)); color:#ffffff; box-shadow: 0 4px 15px rgba(0,102,255,.3); }
        .btn.primary:hover{ transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,102,255,.4); }
        .status{ color:var(--primary-dark); font-size:14px; background:var(--primary-light); border:2px solid var(--accent-light); padding:12px 16px; border-radius:10px; font-weight:600; margin-bottom: 20px; }
        .checkbox-group{ display:flex; flex-wrap:wrap; gap:12px; margin-top:8px; }
        .checkbox-item{ display:flex; align-items:center; gap:8px; }
        .checkbox-item input[type=checkbox]{ width:18px; height:18px; cursor:pointer; }
        @media (max-width: 980px){ .form-grid{ grid-template-columns:1fr; } .sidebar{ position:fixed; left:-280px; top:80px; z-index:999; height:calc(100vh - 80px); transition: left .3s ease; } .sidebar.active{ left:0; } .content-wrapper{ padding: 20px; } }
    </style>
</head>
<body>
<div class="shell">
    <header class="topbar">
        <div style="display:flex; align-items:center; gap:16px;">
            <div class="brand">
                @php
                    $logoPath = null;
                    $possibleLogos = ['logo.png', 'logo.jpg', 'logo.svg'];
                    foreach ($possibleLogos as $file) {
                        if (file_exists(public_path('images/logo/' . $file))) {
                            $logoPath = asset('images/logo/' . $file);
                            break;
                        }
                    }
                @endphp
                @if ($logoPath)
                    <img src="{{ $logoPath }}" alt="Logo" style="width:56px; height:56px; border-radius:16px; object-fit:contain; background:#fff; padding:8px; box-shadow: 0 4px 12px rgba(0,102,255,.3);">
                @else
                    <span style="width:56px; height:56px; border-radius:16px; background:linear-gradient(135deg, var(--primary), var(--accent)); display:grid; place-items:center; color:#fff; font-weight:800; font-size:24px;">M</span>
                @endif
                <div>
                    <div class="logo-text">Metrochilon Admin</div>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </header>

    <div class="main-wrapper">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-user">
                    <span class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                    <div class="sidebar-user-info">
                        <h4>{{ auth()->user()->name ?? 'Admin' }}</h4>
                        <small>Administrator</small>
                    </div>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-item">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.employees.index') }}" class="nav-item">
                    <span>Manajemen Karyawan</span>
                </a>
                <a href="{{ route('admin.leaves.index') }}" class="nav-item">
                    <span>Pengajuan Cuti</span>
                </a>
                <a href="{{ route('admin.attendance-settings.index') }}" class="nav-item active">
                    <span>Pengaturan Absensi</span>
                </a>
                <a href="{{ route('admin.locations.page') }}" class="nav-item">
                    <span>Lokasi Karyawan</span>
                </a>
                <a href="{{ route('admin.attendances.page') }}" class="nav-item">
                    <span>Absensi</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="nav-item" style="width:100%; background:none; border:none; text-align:left; color:var(--primary);">
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <div class="content-wrapper">
            <div class="card pad">
                <div class="hero">
                    <div>
                        <h3>Pengaturan Absensi</h3>
                        <small>Konfigurasi jam kerja, lokasi, dan hari kerja</small>
                    </div>
                </div>
                <div class="pad">
                    @if (session('status'))
                        <div class="status">{{ session('status') }}</div>
                    @endif
                    <form method="POST" action="{{ route('admin.attendance-settings.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="field">
                            <label class="txt">Nama Pengaturan</label>
                            <input type="text" name="name" value="{{ $settings->name ?? 'Default' }}" required>
                        </div>
                        <div class="form-grid">
                            <div class="field">
                                <label class="txt">Check In Start</label>
                                <input type="time" name="check_in_start" value="{{ $settings->check_in_start ?? '07:00' }}" required>
                            </div>
                            <div class="field">
                                <label class="txt">Check In End</label>
                                <input type="time" name="check_in_end" value="{{ $settings->check_in_end ?? '09:00' }}" required>
                            </div>
                            <div class="field">
                                <label class="txt">Check Out Start</label>
                                <input type="time" name="check_out_start" value="{{ $settings->check_out_start ?? '16:00' }}" required>
                            </div>
                            <div class="field">
                                <label class="txt">Check Out End</label>
                                <input type="time" name="check_out_end" value="{{ $settings->check_out_end ?? '18:00' }}" required>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="field">
                                <label class="txt">Latitude (Opsional)</label>
                                <input type="text" name="latitude" value="{{ $settings->latitude ?? '' }}" placeholder="-6.2088">
                            </div>
                            <div class="field">
                                <label class="txt">Longitude (Opsional)</label>
                                <input type="text" name="longitude" value="{{ $settings->longitude ?? '' }}" placeholder="106.8456">
                            </div>
                            <div class="field">
                                <label class="txt">Radius (Meter)</label>
                                <input type="number" name="radius_meters" value="{{ $settings->radius_meters ?? 100 }}" min="10" required>
                            </div>
                            <div class="field">
                                <label class="txt">Timezone</label>
                                <select name="timezone" required>
                                    <option value="Asia/Jakarta" {{ ($settings->timezone ?? 'Asia/Jakarta') === 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta</option>
                                    <option value="Asia/Makassar" {{ ($settings->timezone ?? '') === 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar</option>
                                    <option value="Asia/Jayapura" {{ ($settings->timezone ?? '') === 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura</option>
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <label class="txt">Hari Kerja</label>
                            <div class="checkbox-group">
                                @php
                                    $workingDays = $settings->working_days ?? ['monday','tuesday','wednesday','thursday','friday'];
                                    $days = ['monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu', 'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu', 'sunday' => 'Minggu'];
                                @endphp
                                @foreach($days as $key => $label)
                                    <div class="checkbox-item">
                                        <input type="checkbox" name="working_days[]" value="{{ $key }}" id="day_{{ $key }}" {{ in_array($key, $workingDays) ? 'checked' : '' }}>
                                        <label for="day_{{ $key }}" style="cursor:pointer; margin:0;">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div style="margin-top:24px;">
                            <button type="submit" class="btn primary">Simpan Pengaturan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
