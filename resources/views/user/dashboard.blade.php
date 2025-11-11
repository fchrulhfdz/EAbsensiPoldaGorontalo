@extends('layouts.app')

@section('title', 'Dashboard Personel')

@section('content')
<div x-data="attendanceApp">
    <!-- Header Dashboard -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-800 text-white rounded-xl shadow-lg p-6 mb-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">DASHBOARD PERSONEL</h1>
                <p class="text-yellow-200 mt-1">Sistem Informasi Absensi Kehadiran - Polda Gorontalo</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-blue-200">Selamat Datang</p>
                <p class="text-lg font-bold text-yellow-400">{{ Auth::user()->pangkat }} {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    <!-- Info Sistem -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <p class="text-sm text-yellow-800 font-semibold">
                    INFORMASI SISTEM: Login dapat dilakukan dari mana saja, namun proses absensi harus dilakukan dalam radius 100 meter dari Markas Polda Gorontalo.
                </p>
            </div>
        </div>
    </div>

    <!-- Status Absensi Hari Ini -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border border-blue-200">
        <h2 class="text-xl font-bold mb-4 text-blue-900 border-b-2 border-yellow-500 pb-2">STATUS ABSENSI HARI INI</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Jam Masuk -->
            <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                <div class="flex items-center space-x-2 mb-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-semibold text-blue-800">JAM MASUK</p>
                </div>
                <p class="text-2xl font-bold text-blue-900">{{ $todayAttendance->jam_masuk ?? '-' }}</p>
            </div>

            <!-- Jam Pulang -->
            <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                <div class="flex items-center space-x-2 mb-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <p class="text-sm font-semibold text-green-800">JAM PULANG</p>
                </div>
                <p class="text-2xl font-bold text-green-900">{{ $todayAttendance->jam_pulang ?? '-' }}</p>
            </div>

            <!-- Status -->
            <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                <div class="flex items-center space-x-2 mb-2">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-semibold text-yellow-800">STATUS KEHADIRAN</p>
                </div>
                <p class="text-2xl font-bold text-yellow-900 capitalize">{{ $todayAttendance->status ?? 'BELUM ABSEN' }}</p>
            </div>
        </div>

        <!-- Tombol Absensi -->
        <div class="flex space-x-4 mb-4">
            <button @click="checkIn" 
                    :disabled="loading || {{ $todayAttendance && $todayAttendance->jam_masuk ? 'true' : 'false' }}"
                    class="flex items-center space-x-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>ABSEN MASUK</span>
            </button>
            
            <button @click="checkOut" 
                    :disabled="loading || {{ !$todayAttendance || !$todayAttendance->jam_masuk || $todayAttendance->jam_pulang ? 'true' : 'false' }}"
                    class="flex items-center space-x-2 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>ABSEN PULANG</span>
            </button>
        </div>

        <!-- Lokasi Saat Ini -->
        <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-blue-800">LOKASI SAAT INI:</p>
                    <p class="text-sm font-mono text-blue-900" x-text="locationCoordinates || 'Mendeteksi lokasi...'"></p>
                </div>
                <button @click="updateLocation" :disabled="loading"
                        class="flex items-center space-x-1 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 disabled:opacity-50 transition duration-200 text-sm font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>PERBARUI LOKASI</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Daftar Personel -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-200">
        <h2 class="text-xl font-bold mb-4 text-blue-900 border-b-2 border-yellow-500 pb-2">DAFTAR PERSONEL</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-900 to-blue-800 text-white">
                        <th class="px-6 py-3 text-left font-semibold">NAMA</th>
                        <th class="px-6 py-3 text-left font-semibold">NRP</th>
                        <th class="px-6 py-3 text-left font-semibold">JABATAN</th>
                        <th class="px-6 py-3 text-left font-semibold">PANGKAT</th>
                        <th class="px-6 py-3 text-left font-semibold">STATUS HARI INI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    @php
                        $userTodayAttendance = \App\Models\Attendance::where('user_id', $user->id)
                            ->whereDate('tanggal', today())
                            ->first();
                    @endphp
                    <tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 font-mono text-blue-900">{{ $user->nrp }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $user->jabatan }}</td>
                        <td class="px-6 py-4 font-semibold text-blue-800">{{ $user->pangkat }}</td>
                        <td class="px-6 py-4">
                            @if($userTodayAttendance)
                                <div class="flex flex-col space-y-1">
                                    <span class="px-3 py-1 text-xs rounded-full font-semibold 
                                        {{ $userTodayAttendance->status === 'hadir' ? 'bg-green-100 text-green-800 border border-green-300' : '' }}
                                        {{ $userTodayAttendance->status === 'pulang_cepat' ? 'bg-yellow-100 text-yellow-800 border border-yellow-300' : '' }}
                                        {{ $userTodayAttendance->status === 'izin' ? 'bg-blue-100 text-blue-800 border border-blue-300' : '' }}
                                        {{ $userTodayAttendance->status === 'sakit' ? 'bg-red-100 text-red-800 border border-red-300' : '' }}">
                                        {{ strtoupper(str_replace('_', ' ', $userTodayAttendance->status)) }}
                                    </span>
                                    <div class="text-xs text-gray-500">
                                        <span class="font-medium">Masuk:</span> {{ $userTodayAttendance->jam_masuk ?? '-' }}
                                        @if($userTodayAttendance->jam_pulang)
                                            | <span class="font-medium">Pulang:</span> {{ $userTodayAttendance->jam_pulang }}
                                        @endif
                                    </div>
                                </div>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800 border border-gray-300 font-semibold">
                                    BELUM ABSEN
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Alasan Pulang Cepat -->
    <div x-show="showReasonModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md border-2 border-yellow-500">
            <div class="flex items-center space-x-2 mb-4">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <h3 class="text-lg font-bold text-blue-900">ALASAN PULANG CEPAT</h3>
            </div>
            <textarea x-model="reason" placeholder="Masukkan alasan pulang cepat..." 
                     class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                     rows="4"></textarea>
            <div class="flex justify-end space-x-2 mt-4">
                <button @click="showReasonModal = false" 
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-200 font-semibold">
                    BATAL
                </button>
                <button @click="confirmCheckOut" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 font-semibold">
                    KONFIRMASI
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('attendanceApp', () => ({
        loading: false,
        showReasonModal: false,
        reason: '',
        locationCoordinates: 'Mendeteksi lokasi...',
        currentLocation: null,

        init() {
            this.updateLocation();
        },

        async updateLocation() {
            try {
                const position = await this.getCurrentPosition();
                this.currentLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                this.locationCoordinates = `Lat: ${this.currentLocation.lat.toFixed(6)}, Lng: ${this.currentLocation.lng.toFixed(6)}`;
            } catch (error) {
                this.locationCoordinates = 'Gagal mendeteksi lokasi';
                console.error('Location error:', error);
            }
        },

        async checkIn() {
            this.loading = true;
            
            try {
                // Update location terlebih dahulu
                await this.updateLocation();
                
                const response = await fetch('{{ route("attendance.checkin") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        latitude: this.currentLocation.lat,
                        longitude: this.currentLocation.lng
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    alert('Absen masuk berhasil!');
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Gagal melakukan absen: ' + error.message);
            } finally {
                this.loading = false;
            }
        },

        async checkOut() {
            const currentTime = new Date();
            const currentHour = currentTime.getHours();
            
            // Jika sebelum jam 17:00, minta alasan
            if (currentHour < 17) {
                this.showReasonModal = true;
            } else {
                await this.performCheckOut('');
            }
        },

        async confirmCheckOut() {
            this.showReasonModal = false;
            await this.performCheckOut(this.reason);
            this.reason = '';
        },

        async performCheckOut(alasan) {
            this.loading = true;
            
            try {
                // Update location terlebih dahulu
                await this.updateLocation();
                
                const response = await fetch('{{ route("attendance.checkout") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        latitude: this.currentLocation.lat,
                        longitude: this.currentLocation.lng,
                        alasan: alasan
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    alert('Absen pulang berhasil!');
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Gagal melakukan absen: ' + error.message);
            } finally {
                this.loading = false;
            }
        },

        getCurrentPosition() {
            return new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(resolve, reject, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            });
        }
    }));
});
</script>
@endsection