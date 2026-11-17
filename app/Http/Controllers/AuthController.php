<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('landing');
        }

        return view('auth.login');
    }

    /**
     * Show registration form for Renter or Owner.
     */
    public function showRegister(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('landing');
        }

        $selectedRole = in_array($request->query('role'), ['renter', 'owner'], true)
            ? $request->query('role')
            : 'renter';

        return view('auth.register', compact('selectedRole'));
    }

    /**
     * Handle user registration (Renter or Owner).
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:25'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'string', 'in:renter,owner'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk ke akun Anda.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'role.in' => 'Pilihan peran pendaftaran tidak valid.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $successMessage = $user->isOwner()
            ? "Pendaftaran berhasil! Selamat datang sebagai Mitra Rental (Owner), {$user->name}."
            : "Pendaftaran berhasil! Selamat datang di U.N.O Rental, {$user->name}. Silakan pilih barang untuk disewa.";

        return redirect()->route('landing')->with('success', $successMessage);
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->isAdmin()) {
                if ($request->wantsJson()) {
                    return response()->json(['success' => true, 'redirect' => route('admin.dashboard')]);
                }

                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali di Admin Panel, '.$user->name);
            }

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'redirect' => route('landing')]);
            }

            return redirect()->route('landing');
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Email atau password salah'], 422);
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok dengan data kami.',
        ])->withInput($request->only('email'));
    }

    /**
     * Quick login as demo user / owner / admin for instant testing.
     */
    public function quickLogin(string $role = 'admin'): RedirectResponse
    {
        $user = match ($role) {
            'admin' => User::where('role', 'admin')->first(),
            'owner' => User::where('role', 'owner')->first() ?? User::where('email', 'ahmad@example.com')->first(),
            'renter' => User::where('role', 'renter')->first() ?? User::where('email', 'budi@example.com')->first(),
            default => User::where('role', 'renter')->first() ?? User::where('role', 'user')->first(),
        };

        if ($user) {
            Auth::login($user);

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Login berhasil sebagai '.$user->name.' ('.$user->role_label.')');
            }

            return redirect()->route('landing');
        }

        return redirect()->route('login')->with('error', 'Akun demo untuk peran tersebut belum tersedia.');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
