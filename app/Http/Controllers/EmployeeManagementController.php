<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeManagementController extends Controller
{
    // Tampilkan daftar karyawan
    public function index()
    {
        $employees = User::where('role', 'karyawan')
            ->latest()
            ->paginate(20);
        
        return view('admin.employees.index', compact('employees'));
    }

    // Tampilkan form tambah karyawan
    public function create()
    {
        return view('admin.employees.create');
    }

    // Simpan karyawan baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'employee_id' => 'nullable|string|unique:users,employee_id',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'karyawan';

        User::create($data);

        return redirect()->route('admin.employees.index')->with('status', 'Karyawan berhasil ditambahkan.');
    }

    // Tampilkan detail karyawan
    public function show($id)
    {
        $employee = User::with(['attendances', 'leaves'])
            ->findOrFail($id);
        
        return view('admin.employees.show', compact('employee'));
    }

    // Generate a temporary password for an employee and flag for mandatory change
    public function setTemporaryPassword($id)
    {
        $employee = User::findOrFail($id);

        // Generate a secure temporary password
        $tempPassword = bin2hex(random_bytes(5)); // 10 hex chars

        $employee->password = Hash::make($tempPassword);
        $employee->must_change_password = true;
        $employee->save();

        // Optionally: send temporary password to employee email (will use log driver in dev)
        if ($employee->email) {
            try {
                // send notification (uses mail driver - log in dev)
                $employee->notify(new \App\Notifications\TemporaryPasswordNotification($tempPassword));
            } catch (\Exception $e) {
                // ignore mail failure for now
            }
        }

        return back()->with('temp_password', $tempPassword)->with('status', 'Password sementara telah di-generate. Salin password ini dan beri tahu karyawan.');
    }

    // Tampilkan form edit karyawan
    public function edit($id)
    {
        $employee = User::findOrFail($id);
        
        return view('admin.employees.edit', compact('employee'));
    }

    // Update karyawan
    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'employee_id' => 'nullable|string|unique:users,employee_id,' . $id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('status', 'Data karyawan berhasil diperbarui.');
    }

    // Hapus karyawan
    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();

        return back()->with('status', 'Karyawan berhasil dihapus.');
    }
}
