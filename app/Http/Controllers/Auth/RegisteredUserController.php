<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'asal_sekolah' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generate Nomor Registrasi
        $year = date('Y');
        $lastUser = User::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $lastNumber = $lastUser ? intval(substr($lastUser->nomor_registrasi, -5)) : 0;
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        $nomorRegistrasi = $year . '-' . $newNumber;

        $user = User::create([
            'nama' => $request->nama,
            'asal_sekolah' => $request->asal_sekolah,
            'nisn' => $request->nisn,
            'nomor_registrasi' => $nomorRegistrasi,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'is_active' => false,
        ]);

        return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Akun Anda akan segera diaktifkan oleh admin.');
    }
}
