<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absensi - Dashboard Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .page-wrap { min-height: 100vh; padding: 2rem; background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); }
        .card { background: white; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
<div class="page-wrap">
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Absensi</h1>
            <p class="text-gray-600">Riwayat lengkap semua absensi Anda</p>
        </div>

        <div class="card">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-3 text-sm font-semibold text-gray-700">Tanggal & Waktu</th>
                            <th class="text-left p-3 text-sm font-semibold text-gray-700">Jenis</th>
                            <th class="text-left p-3 text-sm font-semibold text-gray-700">Koordinat</th>
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
                                    <div class="text-xs">
                                        <div>Lat: {{ number_format($attendance->latitude, 6) }}</div>
                                        <div>Lng: {{ number_format($attendance->longitude, 6) }}</div>
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <a href="{{ asset('storage/'.$attendance->photo_path) }}" target="_blank" class="text-indigo-600 hover:underline text-sm">Lihat Foto</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">Belum ada riwayat absensi</td>
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
            <a href="{{ route('karyawan.dashboard') }}" class="text-indigo-600 hover:underline">← Kembali ke Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>



