@extends('layouts.app')

@section('title', 'Tambah Admin Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-800 text-white rounded-xl shadow-lg p-6 mb-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">TAMBAH ADMIN BARU</h1>
                <p class="text-yellow-200 mt-1">Sistem Informasi Absensi Kehadiran - Polda Gorontalo</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-blue-200">Manajemen Admin</p>
                <p class="text-lg font-bold text-yellow-400">{{ Auth::user()->pangkat }} {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-200">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <strong class="font-semibold">Terjadi Kesalahan:</strong>
                </div>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-blue-900 mb-2">NAMA LENGKAP *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NRP -->
                <div>
                    <label for="nrp" class="block text-sm font-semibold text-blue-900 mb-2">NRP *</label>
                    <input type="text" id="nrp" name="nrp" value="{{ old('nrp') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200 font-mono">
                    @error('nrp')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jabatan -->
                <div>
                    <label for="jabatan" class="block text-sm font-semibold text-blue-900 mb-2">JABATAN *</label>
                    <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                    @error('jabatan')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pangkat -->
                <div>
                    <label for="pangkat" class="block text-sm font-semibold text-blue-900 mb-2">PANGKAT *</label>
                    <select id="pangkat" name="pangkat" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                        <option value="">Pilih Pangkat</option>
                        <option value="IPDA" {{ old('pangkat') == 'IPDA' ? 'selected' : '' }}>IPDA</option>
                        <option value="AKP" {{ old('pangkat') == 'AKP' ? 'selected' : '' }}>AKP</option>
                        <option value="KOMPOL" {{ old('pangkat') == 'KOMPOL' ? 'selected' : '' }}>KOMPOL</option>
                        <option value="AKBP" {{ old('pangkat') == 'AKBP' ? 'selected' : '' }}>AKBP</option>
                        <option value="KOMBES POL" {{ old('pangkat') == 'KOMBES POL' ? 'selected' : '' }}>KOMBES POL</option>
                        <option value="BRIGPOL" {{ old('pangkat') == 'BRIGPOL' ? 'selected' : '' }}>BRIGPOL</option>
                        <option value="BRIPTU" {{ old('pangkat') == 'BRIPTU' ? 'selected' : '' }}>BRIPTU</option>
                        <option value="AIPTU" {{ old('pangkat') == 'AIPTU' ? 'selected' : '' }}>AIPTU</option>
                        <option value="PNS" {{ old('pangkat') == 'PNS' ? 'selected' : '' }}>PNS</option>
                    </select>
                    @error('pangkat')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-semibold text-blue-900 mb-2">EMAIL *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-blue-900 mb-2">PASSWORD *</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-blue-900 mb-2">KONFIRMASI PASSWORD *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-semibold text-blue-800">INFORMASI:</p>
                </div>
                <ul class="text-xs text-blue-700 mt-2 list-disc list-inside space-y-1">
                    <li>Admin yang dibuat akan memiliki akses penuh ke sistem absensi</li>
                    <li>Pastikan data yang dimasukkan sudah benar dan valid</li>
                    <li>Password harus minimal 8 karakter</li>
                </ul>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.management') }}" 
                   class="flex items-center space-x-2 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-200 font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>BATAL</span>
                </a>
                <button type="submit" 
                        class="flex items-center space-x-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>SIMPAN ADMIN</span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
</style>
@endsection