@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Header Logo -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center space-x-3 mb-4">
                <div class="relative">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center border-4 border-yellow-500 shadow-lg">
                        <svg class="w-10 h-10 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 5.5V7H9V5.5L3 7V9L5 9.5V15.5L3 16V18L9 16.5V18H15V16.5L21 18V16L19 15.5V9.5L21 9Z"/>
                        </svg>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-red-600 rounded-full flex items-center justify-center shadow-md">
                        <span class="text-xs font-bold text-white">ID</span>
                    </div>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-blue-900 mb-2">SIAK POLDA GORONTALO</h1>
            <p class="text-sm text-blue-700 font-medium">Sistem Informasi Absensi Kehadiran</p>
            <div class="w-20 h-1 bg-yellow-500 mx-auto mt-3 rounded-full"></div>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-blue-200 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-900 to-blue-800 px-6 py-4">
                <h2 class="text-xl font-bold text-white text-center">LOGIN SISTEM</h2>
                <p class="text-yellow-200 text-sm text-center mt-1">Masukkan kredensial Anda untuk mengakses sistem</p>
            </div>

            <!-- Login Form -->
            <div class="p-6">
                <form id="loginForm" x-data="loginForm()" @submit.prevent="submitForm">
                    <!-- CSRF Token Hidden Field -->
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    
                    <!-- Email Field -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-blue-900 mb-2">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                                <span>EMAIL</span>
                            </div>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            x-model="form.email"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                            placeholder="email@polri.go.id"
                        >
                    </div>

                    <!-- Password Field -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-blue-900 mb-2">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>PASSWORD</span>
                            </div>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            x-model="form.password"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200"
                            placeholder="Masukkan password Anda"
                        >
                    </div>

                    <!-- Alert Message -->
                    <div 
                        x-show="showMessage" 
                        x-text="message" 
                        :class="{
                            'bg-green-100 text-green-800 border border-green-300': messageType === 'success',
                            'bg-red-100 text-red-800 border border-red-300': messageType === 'error',
                            'bg-blue-100 text-blue-800 border border-blue-300': messageType === 'info'
                        }"
                        class="p-4 rounded-lg mb-4 transition-all duration-300 whitespace-pre-line font-medium"
                        x-transition
                    ></div>

                    <!-- Login Button -->
                    <button 
                        type="submit" 
                        :disabled="loading"
                        :class="{
                            'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 shadow-lg': !loading,
                            'bg-blue-400 cursor-not-allowed': loading
                        }"
                        class="w-full text-white py-3 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center font-semibold text-lg"
                    >
                        <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="loading ? 'SEDANG MEMPROSES...' : 'MASUK SISTEM'"></span>
                    </button>
                </form>

                <!-- Info Login -->
                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-semibold text-yellow-800">INFORMASI SISTEM</p>
                    </div>
                    <p class="text-sm text-yellow-700">
                        Semua personel dapat login dari mana saja. Validasi lokasi hanya diperlukan untuk proses absensi.
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
                &copy; 2024 SIAK Polda Gorontalo. Sistem Informasi Absensi Kehadiran.
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('loginForm', () => ({
        loading: false,
        showMessage: false,
        message: '',
        messageType: 'error',
        form: {
            email: '',
            password: ''
        },

        async submitForm() {
            this.loading = true;
            this.showMessage = false;

            try {
                // Get CSRF token from hidden field
                const csrfToken = document.getElementById('_token').value;

                // Coba dapatkan lokasi (opsional, tidak wajib untuk login)
                let latitude = null;
                let longitude = null;

                try {
                    const position = await this.getCurrentPosition();
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;
                    console.log('Location detected (optional):', latitude, longitude);
                } catch (locationError) {
                    console.log('Location not available, but login can continue');
                    // Lokasi tidak wajib untuk login, jadi kita lanjutkan saja
                }

                // Prepare form data
                const formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('email', this.form.email);
                formData.append('password', this.form.password);
                
                // Tambahkan lokasi jika tersedia (opsional)
                if (latitude && longitude) {
                    formData.append('latitude', latitude);
                    formData.append('longitude', longitude);
                }

                await this.sendLoginRequest(formData);

            } catch (error) {
                console.error('Login error:', error);
                this.message = 'Gagal melakukan login: ' + error.message;
                this.messageType = 'error';
                this.showMessage = true;
            } finally {
                this.loading = false;
            }
        },

        async sendLoginRequest(formData) {
            this.message = 'Sedang memproses login...';
            this.messageType = 'info';
            this.showMessage = true;
            
            try {
                const response = await fetch('{{ route("login.post") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.getElementById('_token').value
                    }
                });

                const data = await response.json();
                console.log('Login response:', data);

                if (data.success) {
                    this.message = data.message || 'Login berhasil! Mengalihkan ke dashboard...';
                    this.messageType = 'success';
                    
                    // Redirect after success
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                } else {
                    this.message = data.message || 'Login gagal! Periksa kembali email dan password Anda.';
                    this.messageType = 'error';
                }
            } catch (error) {
                console.error('Request error:', error);
                this.message = 'Terjadi kesalahan jaringan. Silakan periksa koneksi internet dan coba lagi.';
                this.messageType = 'error';
            }
        },

        getCurrentPosition() {
            return new Promise((resolve, reject) => {
                if (!navigator.geolocation) {
                    reject(new Error('Browser tidak mendukung geolocation'));
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        resolve(position);
                    },
                    (error) => {
                        let errorMessage = 'Gagal mendapatkan lokasi: ';
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Izin lokasi ditolak.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Informasi lokasi tidak tersedia.';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Request lokasi timeout.';
                                break;
                            default:
                                errorMessage += 'Error tidak diketahui.';
                                break;
                        }
                        reject(new Error(errorMessage));
                    },
                    {
                        enableHighAccuracy: false, // Tidak perlu high accuracy untuk login
                        timeout: 5000, // Timeout lebih cepat
                        maximumAge: 300000 // 5 minutes cache
                    }
                );
            });
        }
    }));
});
</script>
@endpush