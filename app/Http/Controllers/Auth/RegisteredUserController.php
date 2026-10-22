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
use Illuminate\Validation\ValidationException;
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
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        // 1. Ubah bagian validasi ini:
        $request->validate([
            'nama' => ['required', 'string', 'max:255'], // Ganti 'name' jadi 'nama'
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'no_telepon' => ['required', 'string', 'max:20'], // Tambahkan ini
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Ubah bagian create ini:
        $user = User::create([
            'nama' => $request->nama, // Ganti $request->name jadi $request->nama
            'email' => $request->email,
            'no_telepon' => $request->no_telepon, // Tambahkan ini
            'password' => Hash::make($request->password),
            'peran' => 'customer', // Tambahkan ini agar otomatis jadi customer
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
