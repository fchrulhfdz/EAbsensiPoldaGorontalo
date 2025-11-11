<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIAK Polda Gorontalo</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .sticky-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .police-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3730a3 100%);
        }
        .police-badge {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
        }
        .police-gold {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="police-gradient text-white shadow-xl sticky-nav border-b-4 border-yellow-500">
        <div class="max-w-8xl mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <!-- Bagian Kiri: Logo dan Identitas -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3">
                        <!-- Logo Kepolisian -->
                        <div class="relative">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center border-2 border-yellow-500">
                                <svg class="w-8 h-8 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 5.5V7H9V5.5L3 7V9L5 9.5V15.5L3 16V18L9 16.5V18H15V16.5L21 18V16L19 15.5V9.5L21 9Z"/>
                                </svg>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 police-badge rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-white">ID</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-col">
                            <h1 class="text-lg font-bold tracking-tight">SIAK POLDA GORONTALO</h1>
                            <p class="text-xs text-yellow-200 font-medium">Sistem Informasi Absensi Kehadiran</p>
                        </div>
                    </div>
                    
                    @auth
                        <div class="flex items-center space-x-2 police-gold px-3 py-1 rounded-full border border-yellow-400">
                            <svg class="w-4 h-4 text-yellow-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm font-semibold text-yellow-900">
                                {{ Auth::user()->pangkat }} {{ Auth::user()->name }}
                            </span>
                            <span class="text-xs bg-blue-900 text-white px-2 py-1 rounded-full">
                                {{ strtoupper(str_replace('_', ' ', Auth::user()->role)) }}
                            </span>
                        </div>
                    @endauth
                </div>
                
                <!-- Bagian Kanan: Waktu Real-time dan Menu -->
                <div class="flex items-center space-x-6">
                    <!-- Waktu Real-time -->
                    <div x-data="realTimeClock()" 
                         class="bg-blue-900/90 backdrop-blur-sm px-4 py-2 rounded-lg border border-yellow-500/50 shadow-lg">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-center">
                                <div x-text="currentTime" class="font-mono font-bold text-yellow-400 text-sm"></div>
                                <div x-text="currentDate" class="text-xs text-blue-200"></div>
                            </div>
                        </div>
                    </div>
                    
                    @auth
                    <div class="flex items-center space-x-4">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center space-x-2 hover:text-yellow-300 transition duration-200 font-medium group px-3 py-2 rounded-lg hover:bg-blue-800/50">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="font-semibold">DASHBOARD</span>
                        </a>
                        
                        <!-- Menu untuk Admin/Super Admin -->
                        @if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                        <a href="{{ route('attendance.search') }}" 
                           class="flex items-center space-x-2 hover:text-yellow-300 transition duration-200 font-medium group px-3 py-2 rounded-lg hover:bg-blue-800/50">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="font-semibold">DATA ABSENSI</span>
                        </a>
                        @endif
                        
                        <!-- Menu untuk Super Admin -->
                        @if(Auth::user()->isSuperAdmin())
                        <a href="{{ route('admin.management') }}" 
                           class="flex items-center space-x-2 hover:text-yellow-300 transition duration-200 font-medium group px-3 py-2 rounded-lg hover:bg-blue-800/50">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <span class="font-semibold">KELOLA ADMIN</span>
                        </a>
                        @endif
                        
                        <!-- Logout -->
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center space-x-2 hover:text-yellow-300 transition duration-200 font-medium group px-3 py-2 rounded-lg hover:bg-red-800/50">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="font-semibold">LOGOUT</span>
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-8xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer Polisi -->
    <footer class="bg-blue-900 text-white py-4 mt-8 border-t-4 border-yellow-500">
        <div class="max-w-8xl mx-auto px-4 text-center">
            <p class="text-sm font-semibold">SISTEM INFORMASI ABSENSI KEHADIRAN</p>
            <p class="text-xs text-yellow-300 mt-1">KEPOLISIAN DAERAH GORONTALO © 2024</p>
            <p class="text-xs text-blue-200 mt-1">Jl. Jenderal Sudirman No. 69, Kota Gorontalo</p>
        </div>
    </footer>

    <!-- Scripts Section -->
    @stack('scripts')
    @yield('scripts')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('realTimeClock', () => ({
                currentTime: '',
                currentDate: '',

                init() {
                    this.updateTime();
                    // Update waktu setiap detik
                    setInterval(() => {
                        this.updateTime();
                    }, 1000);
                },

                updateTime() {
                    const now = new Date();
                    
                    // Format waktu: HH:MM:SS
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const seconds = String(now.getSeconds()).padStart(2, '0');
                    this.currentTime = `${hours}:${minutes}:${seconds}`;
                    
                    // Format tanggal: Hari, DD Month YYYY
                    const options = { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    };
                    this.currentDate = now.toLocaleDateString('id-ID', options);
                }
            }));
        });
    </script>
</body>
</html>