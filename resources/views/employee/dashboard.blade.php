<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan</title>
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
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .btn-primary { background: linear-gradient(135deg, #0066ff, #00b8d4); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; font-weight: 600; transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3); }
        .soft-list-item { padding: 0.75rem; background: #f9fafb; border-radius: 0.5rem; }
    </style>
</head>
<body>
<div class="page-wrap">
  <div class="max-w-7xl mx-auto">
    <div class="flex gap-6">
      <!-- Sidebar -->
      <aside id="sidebar" class="w-64 hidden lg:block">
        <div class="card sticky top-6">
          <div class="flex items-center gap-3 mb-6">
            <div class="bg-gradient-to-br from-blue-600 to-cyan-500 text-white w-12 h-12 rounded-full flex items-center justify-center text-lg font-semibold">
              {{ strtoupper(substr(auth()->user()->name ?? 'U',0,1)) }}
            </div>
            <div>
              <div class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</div>
              <div class="text-xs text-gray-500">Karyawan Aktif</div>
            </div>
          </div>

          <nav class="space-y-1">
            <a href="{{ route('karyawan.dashboard') }}" class="flex items-center gap-3 p-2 rounded-md bg-gray-50 text-sm text-gray-800">
              <span>Dashboard</span>
            </a>
            <a href="{{ route('attendance.index') }}" class="flex items-center gap-3 p-2 rounded-md text-sm text-gray-700 hover:bg-gray-50">
              <span>Absensi</span>
            </a>
            <a href="{{ route('attendance.history') }}" class="flex items-center gap-3 p-2 rounded-md text-sm text-gray-700 hover:bg-gray-50">
              <span>Riwayat</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-2 rounded-md text-sm text-gray-700 hover:bg-gray-50">
              <span>Pengaturan</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-left flex items-center gap-3 p-2 rounded-md text-sm text-red-600 hover:bg-red-50">
                <span>Logout</span>
              </button>
            </form>
          </nav>
        </div>
      </aside>

      <!-- Main content -->
      <main class="flex-1">
        <div class="page-header">
          <div>
            <h1 class="text-2xl font-semibold text-gray-800">Halo, {{ auth()->user()->name }}</h1>
            <div class="text-sm text-gray-500">Selamat bekerja — ringkasan singkat aktivitas Anda.</div>
          </div>

          <!-- mobile sidebar toggle -->
          <div class="lg:hidden">
            <button id="toggleSidebar" class="btn-primary">Menu</button>
          </div>
        </div>

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div class="card">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Absen Kantor</h2>
            @include('employee.partials.attendance-form')
          </div>

          <div class="card">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Riwayat Absen Terakhir</h2>
            <div class="space-y-3">
              @forelse($activities as $act)
                <div class="soft-list-item flex justify-between items-center">
                  <div class="text-sm text-gray-700">
                    <div class="font-medium">{{ $act->created_at->format('d M Y, H:i') }}</div>
                    <div class="text-xs text-gray-500">{{ strtoupper($act->type) }}</div>
                  </div>
                  <a href="{{ asset('storage/'.$act->photo_path) }}" target="_blank" class="text-sm text-blue-600 hover:underline">Lihat Foto</a>
                </div>
              @empty
                <div class="text-sm text-gray-500 text-center py-4">Belum ada riwayat absen</div>
              @endforelse
            </div>
          </div>

          @if($priorityTasks->count() > 0)
          <div class="lg:col-span-2 card">
            <h2 class="text-lg font-medium text-gray-800 mb-3">Tugas Prioritas</h2>
            <div class="grid md:grid-cols-3 gap-4">
              @foreach($priorityTasks as $t)
                <div class="p-4 rounded-md border border-gray-100 bg-white">
                  <div class="text-sm font-medium text-gray-800">{{ $t->title }}</div>
                  <div class="text-xs text-gray-500 mt-1">Deadline: {{ $t->due_date->format('d M Y') }}</div>
                </div>
              @endforeach
            </div>
          </div>
          @endif
        </div>
      </main>
    </div>
  </div>
</div>

<script>
  // Toggle sidebar on mobile
  document.addEventListener('DOMContentLoaded', function(){
    var btn = document.getElementById('toggleSidebar');
    var sidebar = document.getElementById('sidebar');
    if(btn && sidebar){
      btn.addEventListener('click', function(){ 
        sidebar.classList.toggle('hidden');
        sidebar.classList.toggle('fixed');
        sidebar.classList.toggle('z-50');
        sidebar.classList.toggle('top-0');
        sidebar.classList.toggle('left-0');
        sidebar.classList.toggle('h-screen');
      });
    }
  });
</script>
</body>
</html>