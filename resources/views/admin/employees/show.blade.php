<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Karyawan - Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{ --bg:#f8fafc; --panel:#ffffff; --text:#1f2937; --muted:#6b7280; --primary:#0066ff; --accent:#00b8d4; --primary-light:#e6f2ff; }
        *{ box-sizing:border-box; }
        body{ margin:0; background: linear-gradient(-45deg, #f8fafc, #e6f2ff, #e0f7fa, #f0f9ff, #f8fafc); background-size: 400% 400%; animation: gradientShift 15s ease infinite; position: relative; color:var(--text); font-family:'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto; }
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
        .info-grid{ display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .info-item{ margin-bottom:16px; }
        .info-label{ color:var(--muted); font-size:13px; margin-bottom:6px; font-weight:600; }
        .info-value{ color:var(--text); font-size:15px; }
        .badge{ padding:6px 12px; border-radius:999px; font-size:12px; font-weight:600; display:inline-block; }
        .badge-success{ background:#dcfce7; color:#166534; }
        .badge-warning{ background:#fef3c7; color:#92400e; }
        .badge-danger{ background:#e6f2ff; color:#991b1b; }
        .btn{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:8px 16px; border:none; border-radius:8px; cursor:pointer; font-weight:600; font-size:13px; transition: all .3s ease; text-decoration:none; }
        .btn-primary{ background:linear-gradient(135deg, var(--primary), var(--accent)); color:#fff; }
        .btn:hover{ transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.2); }
        table{ width:100%; border-collapse:separate; border-spacing:0 12px; }
        thead th{ color:#6b7280; font-size:13px; text-align:left; font-weight:600; padding:0 12px 8px; text-transform: uppercase; letter-spacing: .5px; }
        tbody td{ background:#ffffff; padding:14px 12px; border-top:2px solid #f3f4f6; border-bottom:2px solid #f3f4f6; font-size:14px; }
        tbody tr{ transition: all .2s ease; }
        tbody tr:hover{ transform: translateX(4px); }
        tbody tr td:first-child{ border-left:2px solid #f3f4f6; border-top-left-radius:12px; border-bottom-left-radius:12px; }
        tbody tr td:last-child{ border-right:2px solid #f3f4f6; border-top-right-radius:12px; border-bottom-right-radius:12px; }
        @media (max-width: 980px){ .info-grid{ grid-template-columns:1fr; } .sidebar{ position:fixed; left:-280px; top:80px; z-index:999; height:calc(100vh - 80px); transition: left .3s ease; } .sidebar.active{ left:0; } .content-wrapper{ padding: 20px; } }
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
                <a href="{{ route('admin.employees.index') }}" class="nav-item active">
                    <span>Manajemen Karyawan</span>
                </a>
                <a href="{{ route('admin.leaves.index') }}" class="nav-item">
                    <span>Pengajuan Cuti</span>
                </a>
                <a href="{{ route('admin.attendance-settings.index') }}" class="nav-item">
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
                        <h3>Detail Karyawan</h3>
                        <small>Informasi lengkap karyawan</small>
                    </div>
                    <div style="display:flex; gap:12px;">
                        <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('admin.employees.index') }}" class="btn" style="background:#e5e7eb; color:#1f2937;">Kembali</a>
                    </div>
                </div>
                <div class="pad">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value">{{ $employee->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $employee->email }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">ID Karyawan</div>
                            <div class="info-value">{{ $employee->employee_id ?? '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                @if($employee->status === 'active')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($employee->status === 'inactive')
                                    <span class="badge badge-warning">Tidak Aktif</span>
                                @else
                                    <span class="badge badge-danger">Ditangguhkan</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">No. Telepon</div>
                            <div class="info-value">{{ $employee->phone ?? '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tanggal Masuk</div>
                            <div class="info-value">{{ $employee->hire_date ? $employee->hire_date->format('d M Y') : '-' }}</div>
                        </div>
                    </div>
                    @if($employee->address)
                        <div class="info-item" style="margin-top:20px;">
                            <div class="info-label">Alamat</div>
                            <div class="info-value">{{ $employee->address }}</div>
                        </div>
                    @endif

                    @if(session('temp_password'))
                        <div style="margin-top:16px; padding:12px; border-radius:8px; background:#fffbeb; border:1px solid #fef3c7; color:#92400e; font-weight:700;">
                            Password sementara: <span style="font-family:monospace;">{{ session('temp_password') }}</span>
                            <div style="font-size:12px; color:#6b7280; margin-top:6px;">Tunjukkan password ini kepada karyawan sekarang — ini hanya ditampilkan sekali.</div>
                        </div>
                    @endif

                    <div style="margin-top:18px; display:flex; gap:12px; align-items:center;">
                        <form method="POST" action="{{ route('admin.employees.temp_password', $employee->id) }}" onsubmit="return confirm('Generate password sementara untuk {{ addslashes($employee->name) }}?')">
                            @csrf
                            <button type="submit" class="btn" style="background:#ffedd5; color:#9a3412; border:1px solid rgba(0,0,0,0.05);">Generate Password Sementara</button>
                        </form>

                        <form method="POST" action="{{ route('admin.employees.documents.store', $employee->id) }}" enctype="multipart/form-data" style="display:flex; gap:8px; align-items:center;">
                            @csrf
                            <select name="type" required style="padding:8px; border-radius:6px; border:1px solid #e5e7eb;">
                                <option value="contract">Kontrak</option>
                                <option value="ktp">KTP</option>
                                <option value="npwp">NPWP</option>
                                <option value="other">Lainnya</option>
                            </select>
                            <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
                            <button type="submit" class="btn btn-primary">Upload Dokumen</button>
                        </form>
                    </div>

                    @if($employee->documents->count())
                        <div style="margin-top:16px;">
                            <h4>Dokumen</h4>
                            <table style="width:100%; margin-top:8px; border-collapse:collapse;">
                                <thead>
                                    <tr style="text-align:left; color:#6b7280; font-size:13px;"><th>Type</th><th>Nama File</th><th>Ukuran</th><th></th></tr>
                                </thead>
                                <tbody>
                                    @foreach($employee->documents as $doc)
                                        <tr>
                                            <td style="padding:8px 12px;">{{ strtoupper($doc->type) }}</td>
                                            <td style="padding:8px 12px;">{{ $doc->original_name }}</td>
                                            <td style="padding:8px 12px;">{{ number_format($doc->size / 1024, 2) }} KB</td>
                                            <td style="padding:8px 12px; text-align:right;">
                                                <a href="{{ route('admin.employees.documents.download', [$employee->id, $doc->id]) }}" class="btn" style="background:#e6f2ff; color:#0066ff;">Download</a>
                                                <form method="POST" action="{{ route('admin.employees.documents.destroy', [$employee->id, $doc->id]) }}" style="display:inline-block; margin-left:8px;" onsubmit="return confirm('Hapus dokumen ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn" style="background:#fff; border:1px solid #f3f4f6; color:#991b1b;">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card pad">
                <div class="hero">
                    <div>
                        <h3>Riwayat Absensi</h3>
                        <small>5 absensi terakhir</small>
                    </div>
                </div>
                <div class="pad">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employee->attendances->take(5) as $attendance)
                                <tr>
                                    <td>{{ $attendance->created_at->format('d M Y H:i') }}</td>
                                    <td><span class="badge {{ $attendance->type === 'in' ? 'badge-success' : 'badge-danger' }}">{{ strtoupper($attendance->type) }}</span></td>
                                    <td>{{ $attendance->latitude ? number_format($attendance->latitude, 4) : '-' }}, {{ $attendance->longitude ? number_format($attendance->longitude, 4) : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align:center; padding:24px; color:#9ca3af;">Belum ada absensi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
