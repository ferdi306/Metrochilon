<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{ 
            --bg:#f8fafc; 
            --panel:#ffffff; 
            --soft:#ffffff; 
            --text:#1f2937; 
            --muted:#6b7280; 
            --primary:#0066ff; 
            --primary-dark:#0052cc; 
            --primary-light:#e6f2ff;
            --accent:#00b8d4;
            --accent-light:#e0f7fa;
            --success:#10b981;
            --warn:#f59e0b; 
        }
        *{ box-sizing:border-box; }
        body{ 
            margin:0; 
            background: linear-gradient(-45deg, #f8fafc, #e6f2ff, #e0f7fa, #f0f9ff, #f8fafc);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            color:var(--text); 
            font-family:'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto; 
            position: relative;
        }
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
        .topbar{ 
            display:flex; 
            align-items:center; 
            justify-content:space-between; 
            padding:18px 28px; 
            background:linear-gradient(180deg, rgba(255,255,255,.95), rgba(255,255,255,.9)); 
            backdrop-filter: blur(12px); 
            border-bottom:2px solid var(--primary-light); 
            position:sticky; 
            top:0; 
            z-index:10; 
            box-shadow: 0 2px 10px rgba(0,102,255,.05);
        }
        .brand{ display:flex; align-items:center; gap:12px; font-weight:700; letter-spacing:.3px; }
        .brand .logo-text{ 
            font-size:20px; 
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .badge{ padding:6px 12px; border-radius:999px; background:var(--primary-light); color:var(--primary-dark); font-size:12px; font-weight:600; }
        .logout{ 
            background:#fff; 
            color:var(--primary); 
            border:2px solid var(--primary); 
            padding:10px 20px; 
            border-radius:10px; 
            cursor:pointer; 
            font-weight:600;
            transition: all .3s ease;
        }
        .logout:hover{ 
            background:var(--primary); 
            color:#fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,102,255,.3);
        }
        .main-wrapper{ display:flex; flex:1; position: relative; z-index: 1; }
        .sidebar{ 
            width:280px; 
            background:var(--panel); 
            border-right:2px solid var(--primary-light); 
            padding:24px 0; 
            position:sticky; 
            top:0; 
            height:calc(100vh - 80px);
            overflow-y:auto;
            box-shadow: 2px 0 10px rgba(0,102,255,.05);
            z-index: 2;
        }
        .sidebar-header{ 
            padding:0 24px 24px; 
            border-bottom:2px solid var(--primary-light); 
            margin-bottom:24px; 
        }
        .sidebar-user{ 
            display:flex; 
            align-items:center; 
            gap:12px; 
            margin-bottom:16px; 
        }
        .sidebar-user .avatar{ 
            width:48px; 
            height:48px; 
            font-size:20px; 
        }
        .sidebar-user-info h4{ 
            margin:0; 
            font-size:16px; 
            font-weight:700; 
            color:var(--text); 
        }
        .sidebar-user-info small{ 
            color:var(--muted); 
            font-size:12px; 
        }
        .sidebar-nav{ padding:0 16px; }
        .nav-item{ 
            display:flex; 
            align-items:center; 
            gap:12px; 
            padding:14px 16px; 
            margin-bottom:8px; 
            border-radius:12px; 
            color:var(--text); 
            text-decoration:none; 
            font-weight:600; 
            font-size:14px; 
            transition: all .3s ease;
            cursor:pointer;
        }
        .nav-item:hover{ 
            background:var(--primary-light); 
            color:var(--primary); 
            transform: translateX(4px);
        }
        .nav-item.active{ 
            background:linear-gradient(135deg, var(--primary), var(--accent)); 
            color:#fff; 
            box-shadow: 0 4px 12px rgba(0,102,255,.3);
        }
        .nav-item .icon{ 
            width:20px; 
            text-align:center; 
            font-size:18px; 
        }
        .content-wrapper{ flex:1; padding:32px; overflow-x:hidden; position: relative; z-index: 1; }
        .content{ display:grid; grid-template-columns: 1.1fr .9fr; gap:28px; max-width:1400px; width:100%; }
        .mobile-menu-btn{ 
            display:none; 
            background:var(--primary); 
            color:#fff; 
            border:none; 
            padding:10px 16px; 
            border-radius:10px; 
            cursor:pointer; 
            font-weight:600;
            font-size:14px;
        }
        .sidebar-overlay{ 
            display:none; 
            position:fixed; 
            top:0; 
            left:0; 
            right:0; 
            bottom:0; 
            background:rgba(0,0,0,.5); 
            z-index:1000; 
            pointer-events:auto;
        }
        .sidebar-overlay.active{ display:block; left:280px; }
        .sidebar{ pointer-events:auto; }
        .sidebar-nav .nav-item{ pointer-events:auto; }
        .card{ 
            background:var(--panel); 
            border:1px solid rgba(0,102,255,.1); 
            border-radius:20px; 
            box-shadow:0 10px 30px rgba(0,102,255,.1);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(0,102,255,.15);
        }
        .card.pad{ padding:24px; }
        .hero{ 
            display:flex; 
            align-items:center; 
            gap:18px; 
            padding:24px; 
            border-bottom:2px solid var(--primary-light); 
            background: linear-gradient(135deg, rgba(0,102,255,.02), rgba(0,184,212,.02));
        }
        .avatar{ 
            width:56px; 
            height:56px; 
            border-radius:16px; 
            background:linear-gradient(135deg, var(--primary), var(--accent)); 
            display:grid; 
            place-items:center; 
            color:#fff; 
            font-weight:800; 
            font-size:24px;
            box-shadow: 0 4px 12px rgba(0,102,255,.3);
        }
        .hero h3{ margin:0; font-size:20px; font-weight:700; color:#1f2937; }
        .hero small{ color:var(--muted); font-size:13px; }
        .form-grid{ display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .field{ display:block; }
        label.txt{ display:block; color:var(--muted); font-size:13px; margin-bottom:10px; letter-spacing:.2px; font-weight:600; }
        select,input[type=file]{ 
            width:100%; 
            height:50px; 
            padding:12px 16px; 
            background:#fff; 
            color:var(--text); 
            border:2px solid #e5e7eb; 
            border-radius:12px; 
            font-size:14px; 
            transition: all .3s ease;
        }
        input[type=file]{ height:auto; padding:12px; }
        select:focus,input[type=file]:focus{ 
            outline:none; 
            border-color:var(--primary); 
            box-shadow:0 0 0 6px rgba(0,102,255,.1); 
        }
        .btn{ 
            display:inline-flex; 
            align-items:center; 
            justify-content:center; 
            gap:8px; 
            padding:14px 24px; 
            border:none; 
            border-radius:12px; 
            cursor:pointer; 
            font-weight:600; 
            letter-spacing:.3px; 
            font-size:14px;
            transition: all .3s ease;
        }
        .btn.primary{ 
            background:linear-gradient(135deg, var(--primary), var(--accent)); 
            color:#ffffff; 
            box-shadow: 0 4px 15px rgba(220,38,38,.3);
        }
        .btn.primary:hover{ 
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,102,255,.4);
        }
        .btn.secondary{ 
            background:#f3f4f6; 
            color:#1f2937; 
            border:2px solid #e5e7eb; 
        }
        .btn.secondary:hover{ 
            background:#e5e7eb; 
        }
        .status{ 
            color:#991b1b; 
            font-size:14px; 
            background:var(--primary-light); 
            border:2px solid #fecaca; 
            padding:12px 16px; 
            border-radius:10px; 
            font-weight:600;
            margin-bottom: 20px;
        }
        table{ width:100%; border-collapse:separate; border-spacing:0 12px; }
        thead th{ color:#6b7280; font-size:13px; text-align:left; font-weight:600; padding:0 12px 8px; text-transform: uppercase; letter-spacing: .5px; }
        tbody td{ background:#ffffff; padding:14px 12px; border-top:2px solid #f3f4f6; border-bottom:2px solid #f3f4f6; font-size:14px; }
        tbody tr{ transition: all .2s ease; }
        tbody tr:hover{ transform: translateX(4px); }
        tbody tr td:first-child{ border-left:2px solid #f3f4f6; border-top-left-radius:12px; border-bottom-left-radius:12px; }
        tbody tr td:last-child{ border-right:2px solid #f3f4f6; border-top-right-radius:12px; border-bottom-right-radius:12px; }
        tbody a{ color:var(--primary); text-decoration:none; font-weight:600; }
        tbody a:hover{ text-decoration:underline; }
        @media (max-width: 980px){ 
            .content{ grid-template-columns:1fr; } 
            .form-grid{ grid-template-columns:1fr; } 
            .topbar{ padding: 16px 20px; }
            .sidebar{ 
                position:fixed; 
                left:-280px; 
                top:80px; 
                width:280px;
                z-index:1001; 
                height:calc(100vh - 80px);
                transition: left .3s ease;
            }
            .sidebar.active{ left:0; z-index:1001; }
            .mobile-menu-btn{ display:block; }
            .content-wrapper{ padding: 20px; }</style>
</head>
<body>
<div class="shell">
    <header class="topbar">
        <div style="display:flex; align-items:center; gap:16px;">
            <button class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleSidebar()">☰ Menu</button>
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
                    <img src="{{ $logoPath }}" alt="Logo" class="avatar" style="width:56px; height:56px; border-radius:16px; object-fit:contain; background:#fff; padding:8px; box-shadow: 0 4px 12px rgba(0,102,255,.3);">
                @else
                    <span class="avatar">M</span>
                @endif
                <div>
                    <div class="logo-text">Metrochilon</div>
                </div>
            </div>
        </div>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </header>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="main-wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-user">
                    <span class="avatar">{{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}</span>
                    <div class="sidebar-user-info">
                        <h4>{{ $user->name ?? 'Karyawan' }}</h4>
                        <small>Karyawan Aktif</small>
                    </div>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('karyawan.dashboard') }}" class="nav-item active">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('karyawan.absen') }}" class="nav-item">
                    <span>Absen Kantor</span>
                </a>
                <a href="{{ route('leave.create') }}" class="nav-item">
                    <span>Pengajuan Cuti</span>
                </a>
                <a href="{{ route('attendance.history') }}" class="nav-item">
                    <span>Riwayat Absen</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-item">
                    <span>Pengaturan</span>
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
            <main class="content">
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:24px; margin-bottom:32px;">
                    <div class="card pad" style="text-align:center; animation: fadeInUp 0.6s ease-out 0.1s backwards;">
                        <div style="font-size:32px; font-weight:700; color:var(--primary); margin-bottom:8px;" class="counter" data-target="{{ $todayAttendances->count() }}">0</div>
                        <div style="color:var(--muted); font-size:14px;">Absensi Hari Ini</div>
                    </div>
                    <div class="card pad" style="text-align:center; animation: fadeInUp 0.6s ease-out 0.2s backwards;">
                        <div style="font-size:32px; font-weight:700; color:var(--primary); margin-bottom:8px;" class="counter" data-target="{{ $totalThisMonth }}">0</div>
                        <div style="color:var(--muted); font-size:14px;">Absensi Bulan Ini</div>
                    </div>
                </div>
                <style>
                    @@keyframes fadeInUp {
                        from {
                            opacity: 0;
                            transform: translateY(20px);
                        }
                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }
                </style>
                <script>
                    // Counter animation
                    function animateCounter(element, target) {
                        let current = 0;
                        const increment = target / 50;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                element.textContent = target;
                                clearInterval(timer);
                            } else {
                                element.textContent = Math.floor(current);
                            }, 30);
                    }
                    
                    // Initialize counters when page loads
                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelectorAll('.counter').forEach(counter => {
                            const target = parseInt(counter.getAttribute('data-target'));
                            animateCounter(counter, target);
                        });
                    });
                </script>

                <div class="card pad">
                    <div class="hero">
                        <div>
                            <h3>Absensi Hari Ini</h3>
                            <small>Riwayat absensi Anda hari ini</small>
                        </div>
                        <a href="{{ route('attendance.history') }}" style="color:var(--primary); text-decoration:none; font-size:14px; font-weight:600;">Lihat Semua →</a>
                    </div>
                    <div class="pad">
                        @if($todayAttendances->count() > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Jenis</th>
                                    <th>Lokasi</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayAttendances as $a)
                                <tr>
                                    <td>{{ $a->created_at->format('H:i') }}</td>
                                    <td>
                                        @if($a->type === 'in')
                                            <span style="background:#dcfce7; color:#166534; padding:4px 8px; border-radius:6px; font-size:11px; font-weight:600;">MASUK</span>
                                        @else
                                            <span style="background:#fee2e2; color:#991b1b; padding:4px 8px; border-radius:6px; font-size:11px; font-weight:600;">PULANG</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($a->latitude && $a->longitude)
                                            {{ number_format($a->latitude, 4) }}, {{ number_format($a->longitude, 4) }}
                                        @else
                                            <span style="color:#9ca3af;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($a->photo_path)
                                            <a href="{{ asset('storage/'.$a->photo_path) }}" target="_blank" style="color:var(--primary); text-decoration:none; font-weight:600;">Lihat</a>
                                        @else
                                            <span style="color:#9ca3af;">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div style="text-align:center; padding:32px; color:#9ca3af;">
                            <p>Belum ada absensi hari ini</p>
                            <a href="{{ route('karyawan.absen') }}" class="btn primary" style="margin-top:16px; display:inline-block;">Absen Sekarang</a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card pad">
                    <div class="hero">
                        <div>
                            <h3>Absensi Terbaru</h3>
                            <small>5 absensi terbaru Anda</small>
                        </div>
                    </div>
                    <div class="pad">
                        @if($recentAttendances->count() > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Jenis</th>
                                    <th>Lokasi</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAttendances as $a)
                                <tr>
                                    <td>{{ $a->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        @if($a->type === 'in')
                                            <span style="background:#dcfce7; color:#166534; padding:4px 8px; border-radius:6px; font-size:11px; font-weight:600;">MASUK</span>
                                        @else
                                            <span style="background:#fee2e2; color:#991b1b; padding:4px 8px; border-radius:6px; font-size:11px; font-weight:600;">PULANG</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($a->latitude && $a->longitude)
                                            {{ number_format($a->latitude, 4) }}, {{ number_format($a->longitude, 4) }}
                                        @else
                                            <span style="color:#9ca3af;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($a->photo_path)
                                            <a href="{{ asset('storage/'.$a->photo_path) }}" target="_blank" style="color:var(--primary); text-decoration:none; font-weight:600;">Lihat</a>
                                        @else
                                            <span style="color:#9ca3af;">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div style="text-align:center; padding:32px; color:#9ca3af;">
                            Belum ada riwayat absensi
                        </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<script>
// Sidebar toggle for mobile
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (sidebar && overlay) {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }
}

// Close sidebar when clicking outside on mobile
const overlay = document.getElementById('sidebarOverlay');
if (overlay) {
    overlay.addEventListener('click', function() {
        if (window.innerWidth <= 980) {
            toggleSidebar();
        }
    });
}
</script>
</body>
</html>


