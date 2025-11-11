<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use App\Helpers\GeolocationHelper;

class AttendanceController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            return $this->superAdminDashboard();
        } elseif ($user->isAdmin()) {
            return $this->adminDashboard();
        } else {
            return $this->userDashboard();
        }
    }

    private function userDashboard()
    {
        $users = User::where('role', 'user')->get();
        $todayAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        return view('user.dashboard', compact('users', 'todayAttendance'));
    }

    private function adminDashboard()
    {
        // Manual check untuk admin access
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $attendances = Attendance::with('user')
            ->whereDate('tanggal', today())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact('attendances'));
    }

    private function superAdminDashboard()
    {
        // Manual check untuk super admin access
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $admins = User::whereIn('role', ['admin', 'super_admin'])
            ->where('id', '!=', Auth::id())
            ->get();
        
        $attendances = Attendance::with('user')
            ->whereDate('tanggal', today())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('super-admin.dashboard', compact('admins', 'attendances'));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Validasi lokasi HANYA untuk absensi (bukan untuk login)
        if (!GeolocationHelper::isWithinRadius($request->latitude, $request->longitude)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berada di luar area absensi. Silakan datang ke kantor untuk melakukan absensi.'
            ], 403);
        }

        $todayAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        if ($todayAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen masuk hari ini'
            ], 400);
        }

        Attendance::create([
            'user_id' => Auth::id(),
            'tanggal' => today(),
            'jam_masuk' => now()->format('H:i:s'),
            'status' => 'hadir'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absen masuk berhasil'
        ]);
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'alasan' => 'nullable|string'
        ]);

        // Validasi lokasi HANYA untuk absensi (bukan untuk login)
        if (!GeolocationHelper::isWithinRadius($request->latitude, $request->longitude)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berada di luar area absensi. Silakan datang ke kantor untuk melakukan absensi pulang.'
            ], 403);
        }

        $todayAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        if (!$todayAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan absen masuk hari ini'
            ], 400);
        }

        if ($todayAttendance->jam_pulang) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen pulang hari ini'
            ], 400);
        }

        $currentTime = now();
        $isEarlyCheckout = $currentTime->format('H:i') < '17:00'; // Asumsi jam pulang normal 17:00

        $todayAttendance->update([
            'jam_pulang' => $currentTime->format('H:i:s'),
            'alasan' => $isEarlyCheckout ? $request->alasan : null,
            'status' => $isEarlyCheckout ? 'pulang_cepat' : 'hadir'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absen pulang berhasil'
        ]);
    }

    public function search(Request $request)
    {
        // Manual role check untuk admin access
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $search = $request->get('search');
        
        $attendances = Attendance::with('user')
            ->whereHas('user', function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact('attendances'));
    }

    public function generatePDF(Request $request)
    {
        // Manual role check untuk admin access
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $period = $request->get('period', 'daily');
        $date = $request->get('date', today()->format('Y-m-d'));
        
        if ($period === 'daily') {
            $attendances = Attendance::with('user')
                ->whereDate('tanggal', $date)
                ->get();
        } else {
            $month = Carbon::parse($date)->format('Y-m');
            $attendances = Attendance::with('user')
                ->whereYear('tanggal', Carbon::parse($date)->year)
                ->whereMonth('tanggal', Carbon::parse($date)->month)
                ->get();
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.attendance', compact('attendances', 'period', 'date'));
        
        return $pdf->download("laporan-absensi-{$period}-{$date}.pdf");
    }
}