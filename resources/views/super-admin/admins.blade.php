@extends('layouts.app')

@section('title', 'Manajemen Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-800 text-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">MANAJEMEN ADMINISTRATOR</h1>
                <p class="text-yellow-200 mt-1">Kelola Data Administrator Sistem - Polda Gorontalo</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-blue-200">Super Administrator</p>
                <p class="text-lg font-bold text-yellow-400">{{ Auth::user()->pangkat }} {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-lg flex items-center">
        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Action Bar -->
    <div class="flex justify-between items-center bg-white rounded-xl shadow-lg p-4 border border-blue-200">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
            <h2 class="text-lg font-bold text-blue-900">DATA ADMINISTRATOR</h2>
        </div>
        <a href="{{ route('admin.create') }}" 
           class="flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-200 font-semibold shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            <span>TAMBAH ADMIN BARU</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-blue-200">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gradient-to-r from-blue-900 to-blue-800 text-white">
                    <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">NAMA</th>
                    <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">NRP</th>
                    <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">JABATAN</th>
                    <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">PANGKAT</th>
                    <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">EMAIL</th>
                    <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">ROLE</th>
                    <th class="px-6 py-4 text-left font-semibold text-sm uppercase tracking-wider">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($admins as $admin)
                <tr class="hover:bg-blue-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $admin->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-mono text-blue-900">{{ $admin->nrp }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $admin->jabatan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-blue-800">{{ $admin->pangkat }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $admin->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs rounded-full font-semibold border 
                            {{ $admin->role === 'super_admin' ? 'bg-purple-100 text-purple-800 border-purple-300' : 'bg-blue-100 text-blue-800 border-blue-300' }}">
                            {{ strtoupper(str_replace('_', ' ', $admin->role)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-3">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.edit', $admin->id) }}" 
                               class="flex items-center space-x-1 text-yellow-600 hover:text-yellow-800 font-semibold group">
                                <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span>EDIT</span>
                            </a>
                            
                            <!-- Delete Button (Hanya untuk admin biasa) -->
                            @if($admin->role !== 'super_admin')
                            <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus administrator ini?')"
                                        class="flex items-center space-x-1 text-red-600 hover:text-red-800 font-semibold group">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span>HAPUS</span>
                                </button>
                            </form>
                            @else
                            <span class="text-gray-400 text-sm font-semibold">PROTECTED</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <p class="text-lg font-semibold">Tidak ada data administrator</p>
                            <p class="text-sm mt-1">Silakan tambah administrator baru untuk mengelola sistem</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <div class="flex items-start space-x-3">
            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-blue-800">INFORMASI SISTEM:</p>
                <p class="text-sm text-blue-700 mt-1">
                    • <strong>Super Administrator</strong> tidak dapat dihapus dari sistem<br>
                    • Pastikan data administrator yang ditambahkan sudah benar dan valid<br>
                    • Administrator memiliki akses penuh untuk mengelola data absensi
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal Script -->
<script>
function confirmDelete(adminName) {
    return confirm(`Apakah Anda yakin ingin menghapus administrator ${adminName}? Tindakan ini tidak dapat dibatalkan.`);
}
</script>
@endsection