<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $todayAttendances = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->get();
        $recentAttendances = Attendance::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();
        $totalThisMonth = Attendance::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        return view('karyawan.dashboard', compact('user', 'todayAttendances', 'recentAttendances', 'totalThisMonth'));
    }

    public function absenPage()
    {
        $user = Auth::user();
        return view('karyawan.absen', compact('user'));
    }

    public function index()
    {
        $user = Auth::user();
        $attendances = Attendance::where('user_id', $user->id)->latest()->paginate(15);
        return view('employee.attendance.index', compact('user', 'attendances'));
    }

    public function history()
    {
        $user = Auth::user();
        $attendances = Attendance::where('user_id', $user->id)
            ->latest()
            ->paginate(20);
        return view('employee.attendance.history', compact('user', 'attendances'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:in,out',
            'photo' => 'required|image|max:4096',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $path = $request->file('photo')->store('attendance', 'public');

        Attendance::create([
            'user_id' => Auth::id(),
            'type' => $data['type'],
            'photo_path' => $path,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ]);

        return back()->with('status', 'Absen berhasil.');
    }
}


