<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\GeolocationHelper;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {
            // Cek credentials
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                
                // SEMUA USER (termasuk regular user) bisa login dari mana saja
                // Hanya catat lokasi login untuk keperluan logging/tracking
                if ($request->latitude && $request->longitude) {
                    // Log lokasi login (opsional, untuk tracking)
                    \Log::info("User {$user->name} login from location: {$request->latitude}, {$request->longitude}");
                }

                $request->session()->regenerate();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'redirect' => route('dashboard')
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}