<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\GeolocationHelper;

class CheckLocation
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip location check for admin and super admin
        if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())) {
            return $next($request);
        }

        $userLat = $request->input('latitude') ?? $request->header('User-Latitude');
        $userLon = $request->input('longitude') ?? $request->header('User-Longitude');

        if (!$userLat || !$userLon) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lokasi tidak terdeteksi. Pastikan GPS aktif.'
                ], 403);
            }
            return back()->with('error', 'Lokasi tidak terdeteksi. Pastikan GPS aktif.');
        }

        if (!GeolocationHelper::isWithinRadius($userLat, $userLon)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda berada di luar area absensi'
                ], 403);
            }
            return back()->with('error', 'Anda berada di luar area absensi');
        }

        return $next($request);
    }
}