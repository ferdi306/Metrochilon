<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            $user = auth()->user();
            return redirect($user->role === 'admin' ? route('admin.dashboard') : route('karyawan.dashboard'));
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'employee_id' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'karyawan',
            'status' => 'active',
            'employee_id' => $validated['employee_id'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('karyawan.dashboard');
    }

    // Forgot password: show form to request reset link
    public function showForgotPassword()
    {
        return view('auth.passwords.email');
    }

    // Send reset link to the given email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // Show reset password form (with token)
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Handle the password reset
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) use ($request) {
                $user->password = Hash::make($password);
                $user->must_change_password = false;
                $user->save();
                Auth::login($user);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $request->session()->regenerate();
            return redirect()->route('karyawan.dashboard')->with('status', __($status));
        }

        return back()->withErrors(['email' => [__($status)]]);
    }

    // Show force change password form for users required to change password
    public function showForceChangePassword()
    {
        $user = auth()->user();
        if (! $user->must_change_password) {
            return redirect($user->role === 'admin' ? route('admin.dashboard') : route('karyawan.dashboard'));
        }

        return view('auth.passwords.force');
    }

    public function forceChangePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->password = Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        return redirect($user->role === 'admin' ? route('admin.dashboard') : route('karyawan.dashboard'))->with('status', 'Password berhasil diperbarui.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->must_change_password) {
                return redirect()->route('password.force');
            }

            return redirect()->intended($user->role === 'admin' ? route('admin.dashboard') : route('karyawan.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Login gagal.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}


