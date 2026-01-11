<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Cuti - Karyawan</title>
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
        }
        /* MULAI PERBAIKAN CSS TANPA NESTING */
        .shell{ min-height:100vh; display:flex; flex-direction:column; }
        .topbar{ display:flex; align-items:center; justify-content:space-between; padding:18px 28px; background:linear-gradient(180deg, rgba(255,255,255,.95), rgba(255,255,255,.9)); backdrop-filter: blur(12px); border-bottom:2px solid var(--primary-light); position:sticky; top:0; z-index:5; box-shadow: 0 2px 10px rgba(0,102,255,.05); }
        .brand{ display:flex; align-items:center; gap:12px; font-weight:700; letter-spacing:.3px; }
        .brand .logo-text{ font-size:20px; background: linear-gradient(135deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .logout{ background:#fff; color:var(--primary); border:2px solid var(--primary); padding:10px 20px; border-radius:10px; cursor:pointer; font-weight:600; transition: all .3s ease; }
        .logout:hover{ background:var(--primary); color:#fff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,102,255,.3); }
        .main-wrapper{ display:flex; flex:1; }
        .sidebar{ width:280px; background:var(--panel); border-right:2px solid var(--primary-light); padding:24px 0; position:sticky; top:0; height:calc(100vh - 80px); overflow-y:auto; box-shadow: 2px 0 10px rgba(0,102,255,.05); }
        .sidebar-header{ padding:0 24px 24px; border-bottom:2px solid var(--primary-light); margin-bottom:24px; }
        .sidebar-user{ display:flex; align-items:center; gap:12px; margin-bottom:16px; }
        .sidebar-user .avatar{ width:48px; height:48px; font-size:20px; border-radius:12px; background:linear-gradient(135deg, var(--primary), var(--accent)); display:grid; place-items:center; color:#fff; font-weight:800; }
        .sidebar-user-info h4{ margin:0; font-size:16px; font-weight:700; color:var(--text); }
        .sidebar-user-info small{ color:var(--muted); font-size:12px; }
        .sidebar-nav{ padding:0 16px; }
        .nav-item{ display:flex; align-items:center; gap:12px; padding:14px 16px; margin-bottom:8px; border-radius:12px; color:var(--text); text-decoration:none; font-weight:600; font-size:14px; transition: all .3s ease; cursor:pointer; }
        .nav-item:hover{ background:var(--primary-light); color:var(--primary); transform: translateX(4px); }
        .nav-item.active{ background:linear-gradient(135deg, var(--primary), var(--accent)); color:#fff; box-shadow: 0 4px 12px rgba(0,102,255,.3); }
        .content-wrapper{ flex:1; padding:32px; overflow-x:hidden; }
        .card{ background:var(--panel); border:1px solid rgba(0,102,255,.1); border-radius:20px; box-shadow:0 10px 30px rgba(0,102,255,.1); margin-bottom:24px; }
        .card.pad{ padding:24px; }
        .hero{ display:flex; align-items:center; justify-content:space-between; gap:18px; padding:24px; border-bottom:2px solid var(--primary-light); background: linear-gradient(135deg, rgba(0,102,255,.02), rgba(0,184,212,.02)); }
        .hero h3{ margin:0; font-size:20px; font-weight:700; color:#1f2937; }
        .hero small{ color:var(--muted); font-size:13px; }
        .form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
}

.field{
    display:flex;
    flex-direction:column;
    gap:10px;
    margin:0;
}

        label.txt{ display:block; color:var(--muted); font-size:13px; margin-bottom:10px; letter-spacing:.2px; font-weight:600; }
        input[type=text],input[type=date],select,textarea{ width:100%; height:50px; padding:12px 16px; background:#fff; color:var(--text); border:2px solid #e5e7eb; border-radius:12px; font-size:14px; transition: all .3s ease; }
        textarea{ height:auto; min-height:120px; resize:vertical; }
        input:focus,select:focus,textarea:focus{ outline:none; border-color:var(--primary); box-shadow:0 0 0 6px rgba(0,102,255,.1); }
        .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:14px 24px; border:none; border-radius:12px; cursor:pointer; font-weight:600; letter-spacing:.3px; font-size:14px; transition: all .3s ease; }
        .btn.primary{ background:linear-gradient(135deg, var(--primary), var(--accent)); color:#ffffff; box-shadow: 0 4px 15px rgba(0,102,255,.3); }
        .btn.primary:hover{ transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,102,255,.4); }
        .status{ color:#991b1b; font-size:14px; background:var(--primary-light); border:2px solid #e0f7fa; padding:12px 16px; border-radius:10px; font-weight:600; margin-bottom: 20px; }
        table{ width:100%; border-collapse:separate; border-spacing:0 12px; }
        thead th{ color:#6b7280; font-size:13px; text-align:left; font-weight:600; padding:0 12px 8px; text-transform: uppercase; letter-spacing: .5px; }
        tbody td{ background:#ffffff; padding:14px 12px; border-top:2px solid #f3f4f6; border-bottom:2px solid #f3f4f6; font-size:14px; }
        tbody tr{ transition: all .2s ease; }
        tbody tr:hover{ transform: translateX(4px); }
        tbody tr td:first-child{ border-left:2px solid #f3f4f6; border-top-left-radius:12px; border-bottom-left-radius:12px; }
        tbody tr td:last-child{ border-right:2px solid #f3f4f6; border-top-right-radius:12px; border-bottom-right-radius:12px; }
        .badge{ padding:6px 12px; border-radius:999px; font-size:12px; font-weight:600; display:inline-block; }
        .badge-success{ background:#dcfce7; color:#166534; }
        .badge-warning{ background:#fef3c7; color:#92400e; }
        .badge-danger{ background:#e6f2ff; color:#991b1b; }
        @media (max-width: 980px){ .form-grid{ grid-template-columns:1fr; } .sidebar{ position:fixed; left:-280px; top:80px; z-index:999; height:calc(100vh - 80px); transition: left .3s ease; } .sidebar.active{ left:0; } .content-wrapper{ padding: 20px; } }
        /* END OF FLAT CSS
        @keyframes gradientShift {
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
        @keyframes float {
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
            z-index:5; 
            box-shadow: 0 2px 10px rgba(0,102,255,.05);
        .brand{ display:flex; align-items:center; gap:12px; font-weight:700; letter-spacing:.3px; }
        .brand .logo-text{ 
            font-size:20px; 
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        .logout{ 
            background:#fff; 
            color:var(--primary); 
            border:2px solid var(--primary); 
            padding:10px 20px; 
            border-radius:10px; 
            cursor:pointer; 
            font-weight:600;
            transition: all .3s ease;
        .logout:hover{ 
            background:var(--primary); 
            color:#fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,102,255,.3);
        .main-wrapper{ display:flex; flex:1; }
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
        .sidebar-header{ 
            padding:0 24px 24px; 
            border-bottom:2px solid var(--primary-light); 
            margin-bottom:24px; 
        .sidebar-user{ 
            display:flex; 
            align-items:center; 
            gap:12px; 
            margin-bottom:16px; 
        .sidebar-user .avatar{ 
            width:48px; 
            height:48px; 
            font-size:20px; 
            border-radius:12px;
            background:linear-gradient(135deg, var(--primary), var(--accent)); 
            display:grid;
            place-items:center;
            color:#fff;
            font-weight:800;
        .sidebar-user-info h4{ 
            margin:0; 
            font-size:16px; 
            font-weight:700; 
            color:var(--text); 
        .sidebar-user-info small{ 
            color:var(--muted); 
            font-size:12px; 
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
        .nav-item:hover{ 
            background:var(--primary-light); 
            color:var(--primary); 
            transform: translateX(4px);
        .nav-item.active{ 
            background:linear-gradient(135deg, var(--primary), var(--accent)); 
            color:#fff; 
            box-shadow: 0 4px 12px rgba(0,102,255,.3);
        .content-wrapper{ flex:1; padding:32px; overflow-x:hidden; }
        .card{ 
            background:var(--panel); 
            border:1px solid rgba(0,102,255,.1); 
            border-radius:20px; 
            box-shadow:0 10px 30px rgba(0,102,255,.1); 
            margin-bottom:24px;
        .card.pad{ padding:24px; }
        .hero{ 
            display:flex; 
            align-items:center; 
            justify-content:space-between;
            gap:18px; 
            padding:24px; 
            border-bottom:2px solid var(--primary-light); 
            background: linear-gradient(135deg, rgba(0,102,255,.02), rgba(0,184,212,.02));
        .hero h3{ margin:0; font-size:20px; font-weight:700; color:#1f2937; }
        .hero small{ color:var(--muted); font-size:13px; }
        .form-grid{ display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .field{ display:block; margin-bottom:20px; }
        label.txt{ display:block; color:var(--muted); font-size:13px; margin-bottom:10px; letter-spacing:.2px; font-weight:600; }
        input[type=text],input[type=date],select,textarea{ 
            width:100%; 
            height:50px; 
            padding:12px 16px; 
            background:#fff; 
            color:var(--text); 
            border:2px solid #e5e7eb; 
            border-radius:12px; 
            font-size:14px; 
            transition: all .3s ease;
        }textarea{ 
            height:auto; 
            min-height:120px; 
            resize:vertical;
        }input:focus,select:focus,textarea:focus{ 
            outline:none; 
            border-color:var(--primary); 
            box-shadow:0 0 0 6px rgba(0,102,255,.1); 
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
        .btn.primary{ 
            background:linear-gradient(135deg, var(--primary), var(--accent)); 
            color:#ffffff; 
            box-shadow: 0 4px 15px rgba(0,102,255,.3);
        .btn.primary:hover{ 
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,102,255,.4);
        .status{ 
            color:#991b1b; 
            font-size:14px; 
            background:var(--primary-light); 
            border:2px solid #e0f7fa; 
            padding:12px 16px; 
            border-radius:10px; 
            font-weight:600;
            margin-bottom: 20px;
        }table{ width:100%; border-collapse:separate; border-spacing:0 12px; }
        thead th{ color:#6b7280; font-size:13px; text-align:left; font-weight:600; padding:0 12px 8px; text-transform: uppercase; letter-spacing: .5px; }
        tbody td{ background:#ffffff; padding:14px 12px; border-top:2px solid #f3f4f6; border-bottom:2px solid #f3f4f6; font-size:14px; }
        tbody tr{ transition: all .2s ease; }
        tbody tr:hover{ transform: translateX(4px); }
        tbody tr td:first-child{ border-left:2px solid #f3f4f6; border-top-left-radius:12px; border-bottom-left-radius:12px; }
        tbody tr td:last-child{ border-right:2px solid #f3f4f6; border-top-right-radius:12px; border-bottom-right-radius:12px; }
        .badge{ 
            padding:6px 12px; 
            border-radius:999px; 
            font-size:12px; 
            font-weight:600; 
            display:inline-block;
        .badge-success{ background:#dcfce7; color:#166534; }
        .badge-warning{ background:#fef3c7; color:#92400e; }
        .badge-danger{ background:#e6f2ff; color:#991b1b; }
        @media (max-width: 980px){ 
            .form-grid{ grid-template-columns:1fr; } 
            .sidebar{ 
                position:fixed; 
                left:-280px; 
                top:80px; 
                z-index:999; 
                height:calc(100vh - 80px);
                transition: left .3s ease;
            .sidebar.active{ left:0; }
            .content-wrapper{ padding: 20px; }</style> 
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
                <a href="{{ route('karyawan.absen') }}" class="nav-item">
                    <span>Absen Kantor</span>
                </a>
                <a href="{{ route('leave.create') }}" class="nav-item active">
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
                        <h3>Pengajuan Cuti/Izin</h3>
                        <small>Ajukan cuti, izin, atau sakit</small>
                    </div>
                </div>
                <div class="pad">
                    @if (session('status'))
                        <div class="status">{{ session('status') }}</div>
                    @endif
                    <form method="POST" action="{{ route('leave.store') }}">
                        @csrf
                        <div class="form-grid">
                            <div class="field">
                                <label class="txt">Jenis</label>
                                <select name="type" required>
                                    <option value="cuti">Cuti</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                </select>
                            </div>
                            <div class="field">
                                <label class="txt">Tanggal Mulai</label>
                                <input type="date" name="start_date" required>
                            </div>
                            <div class="field">
                                <label class="txt">Tanggal Selesai</label>
                                <input type="date" name="end_date" required>
                            </div>
                        </div>
                        <div class="field" style="grid-column:1 / -1;">
                            <label class="txt">Alasan</label>
                            <textarea name="reason" placeholder="Jelaskan alasan pengajuan cuti/izin..." required minlength="10"></textarea>
                        </div>
                        <div style="margin-top:16px;">
                            <button type="submit" class="btn primary">Kirim Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div> 

            <div class="card pad">
                <div class="hero">
                    <div>
                        <h3>Riwayat Pengajuan</h3>
                        <small>Total cuti yang sudah disetujui: {{ $totalLeaves }} hari</small>
                    </div>
                </div>
                <div class="pad">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Durasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaves as $leave)
                                <tr>
                                    <td>{{ $leave->start_date->format('d M Y') }} - {{ $leave->end_date->format('d M Y') }}</td>
                                    <td>{{ ucfirst($leave->type) }}</td>
                                    <td>{{ $leave->days }} hari</td>
                                    <td>
                                        @if($leave->status === 'approved')
                                            <span class="badge badge-success">Disetujui</span>
                                        @elseif($leave->status === 'rejected')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @else
                                            <span class="badge badge-warning">Menunggu</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align:center; padding:24px; color:#9ca3af;">Belum ada pengajuan cuti</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div style="margin-top:16px;">{{ $leaves->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


