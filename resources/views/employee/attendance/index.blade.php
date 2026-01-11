<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi - Dashboard Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
        body { position: relative; }
        .page-wrap { 
            min-height: 100vh; 
            padding: 2rem; 
            background: linear-gradient(-45deg, #f8fafc, #e6f2ff, #e0f7fa, #f0f9ff, #f8fafc);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            position: relative;
            z-index: 1;
        }
        .card { 
            background: white; 
            border-radius: 1rem; 
            padding: 1.5rem; 
            box-shadow: 0 4px 6px -1px rgba(0, 102, 255, 0.1);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(0, 102, 255, 0.15);
        }
    </style>
</head>
<body>
<div class="page-wrap">
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Absensi</h1>
            <p class="text-gray-600">Daftar semua absensi Anda</p>
        </div>

        <div class="card">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-3 text-sm font-semibold text-gray-700">Tanggal & Waktu</th>
                            <th class="text-left p-3 text-sm font-semibold text-gray-700">Jenis</th>
                            <th class="text-left p-3 text-sm font-semibold text-gray-700">Lokasi</th>
                            <th class="text-left p-3 text-sm font-semibold text-gray-700">Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 text-sm text-gray-700">{{ $attendance->created_at->format('d M Y, H:i:s') }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $attendance->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ strtoupper($attendance->type) }}
                                </span>
                            </td>
                            <td class="p-3 text-sm text-gray-600">
                                @if($attendance->latitude && $attendance->longitude)
                                    {{ number_format($attendance->latitude, 6) }}, {{ number_format($attendance->longitude, 6) }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <a href="{{ asset('storage/'.$attendance->photo_path) }}" target="_blank" class="text-blue-600 hover:underline text-sm">Lihat</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">Belum ada data absensi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $attendances->links() }}
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('karyawan.dashboard') }}" class="text-blue-600 hover:underline">← Kembali ke Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>


