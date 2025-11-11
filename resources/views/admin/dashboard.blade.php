@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Header Dashboard Admin -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-800 text-white rounded-xl shadow-lg p-6 mb-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">DASHBOARD ADMIN</h1>
                <p class="text-yellow-200 mt-1">Sistem Informasi Absensi Kehadiran - Polda Gorontalo</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-blue-200">Hak Akses Administrator</p>
                <p class="text-lg font-bold text-yellow-400">{{ Auth::user()->pangkat }} {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    <!-- Statistik Cepat -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-blue-800">TOTAL HADIR</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $attendances->where('status', 'hadir')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-yellow-800">PULANG CEPAT</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ $attendances->where('status', 'pulang_cepat')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-blue-700">IZIN</p>
                    <p class="text-2xl font-bold text-blue-800">{{ $attendances->where('status', 'izin')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-red-800">SAKIT</p>
                    <p class="text-2xl font-bold text-red-900">{{ $attendances->where('status', 'sakit')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Absensi -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-200">
        <div class="flex justify-between items-center mb-6 pb-4 border-b-2 border-yellow-500">
            <h2 class="text-xl font-bold text-blue-900">DATA ABSENSI HARIAN</h2>
            
            <div class="flex space-x-4">
                <!-- Form Pencarian -->
                <form method="GET" action="{{ route('attendance.search') }}" class="flex space-x-2">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Cari nama personel..." 
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 w-64">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span>CARI</span>
                    </button>
                </form>
                
                <!-- Form Export PDF -->
                <form method="POST" action="{{ route('attendance.pdf') }}" class="flex space-x-2">
                    @csrf
                    <select name="period" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="daily">Harian</option>
                        <option value="monthly">Bulanan</option>
                    </select>
                    <input type="date" name="date" value="{{ today()->format('Y-m-d') }}" 
                           class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200 font-semibold flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>EXPORT PDF</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-900 to-blue-800 text-white">
                        <th class="px-6 py-4 text-left font-semibold text-sm">NAMA PERSONEL</th>
                        <th class="px-6 py-4 text-left font-semibold text-sm">PANGKAT</th>
                        <th class="px-6 py-4 text-left font-semibold text-sm">WAKTU MASUK</th>
                        <th class="px-6 py-4 text-left font-semibold text-sm">WAKTU PULANG</th>
                        <th class="px-6 py-4 text-left font-semibold text-sm">ALASAN PULANG CEPAT</th>
                        <th class="px-6 py-4 text-left font-semibold text-sm">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $attendance->user->name }}</div>
                            <div class="text-sm text-gray-500 font-mono">{{ $attendance->user->nrp }}</div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-blue-800">{{ $attendance->user->pangkat }}</td>
                        <td class="px-6 py-4">
                            @if($attendance->jam_masuk)
                                <span class="font-mono text-green-700 font-semibold">{{ $attendance->jam_masuk }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($attendance->jam_pulang)
                                <span class="font-mono text-blue-700 font-semibold">{{ $attendance->jam_pulang }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($attendance->alasan)
                                <div class="max-w-xs">
                                    <span class="text-sm text-gray-700 bg-yellow-50 px-3 py-1 rounded-lg border border-yellow-200">
                                        {{ $attendance->alasan }}
                                    </span>
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-2 rounded-full text-xs font-semibold border 
                                {{ $attendance->status === 'hadir' ? 'bg-green-100 text-green-800 border-green-300' : '' }}
                                {{ $attendance->status === 'pulang_cepat' ? 'bg-yellow-100 text-yellow-800 border-yellow-300' : '' }}
                                {{ $attendance->status === 'izin' ? 'bg-blue-100 text-blue-800 border-blue-300' : '' }}
                                {{ $attendance->status === 'sakit' ? 'bg-red-100 text-red-800 border-red-300' : '' }}">
                                {{ strtoupper(str_replace('_', ' ', $attendance->status)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-lg font-semibold">Tidak ada data absensi hari ini</p>
                                <p class="text-sm mt-1">Belum ada personel yang melakukan absensi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Informasi Tanggal -->
        <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-800">
                        Data absensi per tanggal: {{ today()->format('d F Y') }}
                    </span>
                </div>
                <div class="text-sm text-blue-600 font-semibold">
                    Total: {{ $attendances->count() }} Personel
                </div>
            </div>
        </div>
    </div>
</div>
@endsection