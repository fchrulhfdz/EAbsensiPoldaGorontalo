@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')
<div class="space-y-6">
    <!-- Header Dashboard Super Admin -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-800 text-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">DASHBOARD SUPER ADMIN</h1>
                <p class="text-yellow-200 mt-1">Sistem Informasi Absensi Kehadiran - Polda Gorontalo</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-blue-200">Super Administrator</p>
                <p class="text-lg font-bold text-yellow-400">{{ Auth::user()->pangkat }} {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Admin -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 border border-blue-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-semibold text-blue-800">TOTAL ADMIN</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $admins->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Absen Hari Ini -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 border border-green-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-semibold text-green-800">ABSEN HARI INI</p>
                    <p class="text-2xl font-bold text-green-900">{{ $attendances->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Pulang Cepat -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 border border-yellow-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-semibold text-yellow-800">PULANG CEPAT</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ $attendances->where('status', 'pulang_cepat')->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Tidak Absen -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600 border border-red-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-semibold text-red-800">TIDAK ABSEN</p>
                    <p class="text-2xl font-bold text-red-900">{{ $attendances->where('status', '!=', 'hadir')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-200">
        <h2 class="text-xl font-bold mb-4 text-blue-900 border-b-2 border-yellow-500 pb-2">AKSI CEPAT</h2>
        <div class="flex space-x-4">
            <a href="{{ route('admin.management') }}" 
               class="flex items-center space-x-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <span>KELOLA ADMIN</span>
            </a>
            <a href="{{ route('attendance.pdf') }}?period=daily&date={{ today()->format('Y-m-d') }}" 
               class="flex items-center space-x-2 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>EXPORT LAPORAN HARIAN</span>
            </a>
        </div>
    </div>

    <!-- Recent Attendance -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-blue-900 border-b-2 border-yellow-500 pb-2">DATA ABSENSI TERBARU</h2>
            
            <div class="flex space-x-4">
                <form method="GET" action="{{ route('attendance.search') }}" class="flex space-x-2">
                    <input type="text" name="search" placeholder="Cari nama personel..." 
                           class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
                        CARI
                    </button>
                </form>
                
                <form method="POST" action="{{ route('attendance.pdf') }}" class="flex space-x-2">
                    @csrf
                    <select name="period" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="daily">Harian</option>
                        <option value="monthly">Bulanan</option>
                    </select>
                    <input type="date" name="date" value="{{ today()->format('Y-m-d') }}" 
                           class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200 font-semibold">
                        CETAK PDF
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-900 to-blue-800 text-white">
                        <th class="px-6 py-3 text-left font-semibold">NAMA PERSONEL</th>
                        <th class="px-6 py-3 text-left font-semibold">TANGGAL</th>
                        <th class="px-6 py-3 text-left font-semibold">WAKTU MASUK</th>
                        <th class="px-6 py-3 text-left font-semibold">WAKTU PULANG</th>
                        <th class="px-6 py-3 text-left font-semibold">ALASAN PULANG CEPAT</th>
                        <th class="px-6 py-3 text-left font-semibold">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            <div class="flex items-center space-x-2">
                                <span>{{ $attendance->user->name }}</span>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                    {{ $attendance->user->pangkat }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">{{ $attendance->tanggal->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            @if($attendance->jam_masuk)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm font-semibold">
                                    {{ $attendance->jam_masuk }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($attendance->jam_pulang)
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm font-semibold">
                                    {{ $attendance->jam_pulang }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $attendance->alasan ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                {{ $attendance->status === 'hadir' ? 'bg-green-100 text-green-800 border border-green-300' : '' }}
                                {{ $attendance->status === 'pulang_cepat' ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' : '' }}
                                {{ $attendance->status === 'izin' ? 'bg-blue-100 text-blue-800 border border-blue-300' : '' }}
                                {{ $attendance->status === 'sakit' ? 'bg-red-100 text-red-800 border border-red-300' : '' }}">
                                {{ strtoupper(str_replace('_', ' ', $attendance->status)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center space-y-2">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-lg font-medium">Tidak ada data absensi hari ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination atau Info -->
        @if($attendances->count() > 0)
        <div class="mt-4 flex justify-between items-center text-sm text-gray-600">
            <div>
                Menampilkan <span class="font-semibold">{{ $attendances->count() }}</span> data absensi hari ini
            </div>
            <div class="text-blue-900 font-semibold">
                {{ now()->format('d F Y') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection