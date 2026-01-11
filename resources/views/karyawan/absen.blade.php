<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Kantor - Karyawan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{ 
            --bg:#f8fafc; 
            --panel:#ffffff; 
            --text:#1f2937; 
            --muted:#6b7280; 
            --primary:#0066ff; 
            --accent:#00b8d4; 
            --primary-light:#e6f2ff;
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
        }50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }33% { transform: translate(30px, -30px) scale(1.1); opacity: 0.9; }
            66% { transform: translate(-20px, 20px) scale(0.9); opacity: 0.95; }
        }
        .shell{ min-height:100vh; display:flex; flex-direction:column; position: relative; z-index: 1; }
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
            z-index:5; 
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
            z-index: 2; 
            height:calc(100vh - 80px);
            overflow-y:auto;
            box-shadow: 2px 0 10px rgba(0,102,255,.05);
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
        .card{ 
            background:var(--panel); 
            border:1px solid rgba(0,102,255,.1);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1; 
            border-radius:20px; 
            box-shadow:0 10px 30px rgba(0,102,255,.1); 
            max-width:800px;
            margin:0 auto;
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
            box-shadow: 0 4px 15px rgba(0,102,255,.3);
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
            border:2px solid #e0f7fa; 
            padding:12px 16px; 
            border-radius:10px; 
            font-weight:600;
            margin-bottom: 20px;
        }
        @media (max-width: 980px){ 
            .form-grid{ grid-template-columns:1fr; } 
            .sidebar{ 
                position:fixed; 
                left:-280px; 
                top:80px; 
                z-index:999; 
                height:calc(100vh - 80px);
                transition: left .3s ease;
            }
            .sidebar.active{ left:0; }
            .content-wrapper{ padding: 20px; }
        }
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
                    <img src="{{ $logoPath }}" alt="Logo" class="avatar" style="width:56px; height:56px; border-radius:16px; object-fit:contain; background:#fff; padding:8px; box-shadow: 0 4px 12px rgba(0,102,255,.3);">
                @else
                    <span class="avatar">M</span>
                @endif
                <div>
                    <div class="logo-text">Metrochilon</div>
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
                    <span class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    <div class="sidebar-user-info">
                        <h4>{{ $user->name }}</h4>
                        <small>Karyawan Aktif</small>
                    </div>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('karyawan.dashboard') }}" class="nav-item">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('karyawan.absen') }}" class="nav-item active">
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
            <div class="card pad">
                <div class="hero">
                    <div>
                        <h3>Absen Kantor</h3>
                        <small>Ambil foto dan kirim posisi saat ini.</small>
                    </div>
                </div>
                <div class="pad">
                    @if (session('status'))
                        <div class="status">{{ session('status') }}</div>
                    @endif
                    <form id="absenForm" method="POST" action="{{ route('attendance.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-grid">
                            <div class="field">
                                <label class="txt">Jenis Absen</label>
                                <select name="type">
                                    <option value="in">Masuk</option>
                                    <option value="out">Pulang</option>
                                </select>
                            </div>
                            <div class="field">
                                <label class="txt">Foto (kamera)</label>
                                <input type="file" name="photo" accept="image/*" capture="environment" required>
                                <small style="display:block; color:#94a3b8; margin-top:6px;">Gunakan kamera belakang untuk hasil terbaik.</small>
                            </div>
                        </div>
                        <input type="hidden" name="latitude" id="lat">
                        <input type="hidden" name="longitude" id="lng">
                        <div style="margin-top:16px; display:flex; gap:12px;">
                            <button type="submit" class="btn primary">Kirim Absen</button>
                            <button id="btnStop" type="button" class="btn secondary" disabled>Stop Tracking</button>
                        </div>
                    </form>
                    <div style="margin-top:10px; color:#9ca3af; font-size:12px;">Status tracking: <span id="trackStatus">meminta izin lokasi...</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Geolocation for absen form once
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function(pos){
    document.getElementById('lat').value = pos.coords.latitude;
    document.getElementById('lng').value = pos.coords.longitude;
  }, function(){}, { enableHighAccuracy: true, maximumAge: 5000 });
}

let watchId = null;
let pingInterval = null;
const statusEl = document.getElementById('trackStatus');
const btnStop = document.getElementById('btnStop');

async function sendPing(lat, lng){
  try {
    const response = await fetch('/loc/ping', {
      method: 'POST',
      headers: { 
        'Content-Type': 'application/json', 
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ latitude: lat, longitude: lng })
    });
    
    if (response.ok) {
      const data = await response.json();
      console.log('Location sent successfully:', lat, lng);
    }
  } catch(e) { 
    console.error('Error sending location:', e);
    statusEl.textContent = 'Error mengirim lokasi.';
    statusEl.style.color = '#dc2626';
  }
}

function startTracking() {
  if (!navigator.geolocation) {
    statusEl.textContent = 'Geolocation tidak didukung oleh browser.';
    statusEl.style.color = '#dc2626';
    return;
  }
  
  statusEl.textContent = 'Tracking aktif - Mengirim lokasi setiap 10 detik...';
  statusEl.style.color = '#16a34a';
  btnStop.disabled = false;
  
  // Send location immediately
  navigator.geolocation.getCurrentPosition(function(pos){
    sendPing(pos.coords.latitude, pos.coords.longitude);
  }, function(err){
    statusEl.textContent = 'Error: ' + err.message;
    statusEl.style.color = '#dc2626';
  }, { enableHighAccuracy: true, maximumAge: 0 });
  
  // Watch position for real-time updates
  watchId = navigator.geolocation.watchPosition(function(pos){
    const { latitude, longitude } = pos.coords;
    // Update form fields
    document.getElementById('lat').value = latitude;
    document.getElementById('lng').value = longitude;
  }, function(err){
    statusEl.textContent = 'Error: ' + err.message;
    statusEl.style.color = '#dc2626';
  }, { 
    enableHighAccuracy: true, 
    maximumAge: 0, 
    timeout: 20000 
  });
  
  // Send ping every 10 seconds for real-time tracking
  pingInterval = setInterval(function(){
    navigator.geolocation.getCurrentPosition(function(pos){
      sendPing(pos.coords.latitude, pos.coords.longitude);
    }, function(err){
      console.error('Error getting position:', err);
    }, { enableHighAccuracy: true, maximumAge: 5000 });
  }, 10000); // Send every 10 seconds
}

// Auto start tracking on page load
startTracking();

let isTracking = true;

btnStop.addEventListener('click', function() {
  if (isTracking) {
    // Stop tracking
    if (watchId !== null) {
      navigator.geolocation.clearWatch(watchId);
      watchId = null;
    }
    if (pingInterval !== null) {
      clearInterval(pingInterval);
      pingInterval = null;
    }
    statusEl.textContent = 'Tracking dihentikan.';
    statusEl.style.color = '#6b7280';
    btnStop.textContent = 'Mulai Tracking';
    isTracking = false;
  } else {
    // Start tracking
    startTracking();
    btnStop.textContent = 'Stop Tracking';
    isTracking = true;
  }
});

// Send location when page becomes visible (user switches back to tab)
document.addEventListener('visibilitychange', function(){
  if (!document.hidden && watchId !== null) {
    navigator.geolocation.getCurrentPosition(function(pos){
      sendPing(pos.coords.latitude, pos.coords.longitude);
    }, function(){}, { enableHighAccuracy: true, maximumAge: 0 });
  }
});
</script>
</body>
</html>

