<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $activities = Attendance::where('user_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();
        
        // Placeholder for tasks - you can implement this later
        $priorityTasks = collect([]);
        
        return view('employee.dashboard', compact('user', 'activities', 'priorityTasks'));
    }
}
