<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    // Karyawan: Tampilkan halaman pengajuan cuti
    public function create()
    {
        $user = Auth::user();
        $leaves = Leave::where('user_id', $user->id)
            ->latest()
            ->paginate(10);
        
        $totalLeaves = Leave::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('days');
        
        return view('employee.leave.create', compact('user', 'leaves', 'totalLeaves'));
    }

    // Karyawan: Simpan pengajuan cuti
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:cuti,izin,sakit',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10',
        ]);

        $start = \Carbon\Carbon::parse($data['start_date']);
        $end = \Carbon\Carbon::parse($data['end_date']);
        $days = $start->diffInDays($end) + 1;

        Leave::create([
            'user_id' => Auth::id(),
            'type' => $data['type'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'days' => $days,
            'reason' => $data['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('leave.create')->with('status', 'Pengajuan cuti berhasil dikirim.');
    }

    // Admin: Tampilkan daftar pengajuan cuti
    public function index()
    {
        $leaves = Leave::with('user')
            ->latest()
            ->paginate(20);
        
        return view('admin.leave.index', compact('leaves'));
    }

    // Admin: Approve pengajuan cuti
    public function approve($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Pengajuan cuti disetujui.');
    }

    // Admin: Reject pengajuan cuti
    public function reject(Request $request, $id)
    {
        $leave = Leave::findOrFail($id);
        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('status', 'Pengajuan cuti ditolak.');
    }
}
