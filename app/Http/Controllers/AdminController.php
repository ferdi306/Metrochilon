<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\LocationPing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalEmployees = User::where('role', 'karyawan')->count();
        $totalAttendances = Attendance::whereDate('created_at', today())->count();
        
        // Check if location_pings table exists before querying
        $activeLocations = 0;
        try {
            if (Schema::hasTable('location_pings')) {
                $activeLocations = LocationPing::where('created_at', '>=', now()->subMinutes(10))
                    ->distinct()
                    ->count('user_id');
            }
        } catch (\Exception $e) {
            $activeLocations = 0;
        }
        
        $recentAttendances = Attendance::with('user:id,name')->latest()->limit(5)->get();
        
        return view('admin.dashboard', compact('totalEmployees', 'totalAttendances', 'activeLocations', 'recentAttendances'));
    }

    public function locationsPage()
    {
        return view('admin.locations.index');
    }

    public function locations(Request $request)
    {
        try {
            if (!Schema::hasTable('location_pings')) {
                return response()->json([]);
            }
            
            $since = now()->subMinutes(10);
            $latestByUser = LocationPing::where('created_at', '>=', $since)
                ->select('user_id')
                ->selectRaw('MAX(id) as max_id')
                ->groupBy('user_id');

            $rows = LocationPing::joinSub($latestByUser, 'latest', function($join){
                    $join->on('location_pings.user_id','=','latest.user_id')
                         ->on('location_pings.id','=','latest.max_id');
                })
                ->with('user:id,name')
                ->get(['location_pings.*']);

            return response()->json($rows);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    public function attendancesPage()
    {
        $attendances = Attendance::with('user:id,name')->latest()->paginate(20);
        return view('admin.attendances.index', compact('attendances'));
    }

    public function attendances()
    {
        $rows = Attendance::with('user:id,name')->latest()->limit(50)->get();
        return response()->json($rows);
    }
}


