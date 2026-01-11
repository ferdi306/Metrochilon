<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSetting;
use Illuminate\Http\Request;

class AttendanceSettingController extends Controller
{
    // Tampilkan halaman pengaturan absensi
    public function index()
    {
        $settings = AttendanceSetting::where('is_active', true)->first();
        
        if (!$settings) {
            $settings = AttendanceSetting::create([
                'name' => 'Default',
                'check_in_start' => '07:00',
                'check_in_end' => '09:00',
                'check_out_start' => '16:00',
                'check_out_end' => '18:00',
                'radius_meters' => 100,
                'working_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                'timezone' => 'Asia/Jakarta',
                'is_active' => true,
            ]);
        }
        
        return view('admin.attendance-settings.index', compact('settings'));
    }

    // Update pengaturan absensi
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'check_in_start' => 'required',
            'check_in_end' => 'required',
            'check_out_start' => 'required',
            'check_out_end' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radius_meters' => 'required|integer|min:10',
            'working_days' => 'required|array',
            'timezone' => 'required|string',
        ]);

        $settings = AttendanceSetting::where('is_active', true)->first();
        
        if ($settings) {
            $settings->update($data);
        } else {
            AttendanceSetting::create(array_merge($data, ['is_active' => true]));
        }

        return back()->with('status', 'Pengaturan absensi berhasil diperbarui.');
    }
}
