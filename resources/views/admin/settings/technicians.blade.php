@extends('layouts.public-app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Teknisi IT</h1>
        <a href="{{ route('tickets.public.index') }}" class="text-sm text-gray-500 hover:text-indigo-600">
            ← Kembali ke Dashboard
        </a>
    </div>
    
    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
            <p class="font-bold text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
            <p class="font-bold text-red-800">{{ session('error') }}</p>
        </div>
    @endif
    
    <!-- Form Tambah Teknisi -->
    <div class="bg-white p-6 rounded-lg shadow mb-8 border border-gray-200">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Teknisi Baru</h2>
        <form action="{{ route('admin.settings.technicians.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @csrf
            <div class="md:col-span-2">
                <input type="text" name="name" placeholder="Nama Lengkap" required 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5">
            </div>
            <div class="md:col-span-2">
                <input type="email" name="email" placeholder="Email Login" required 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5">
            </div>
            <div class="md:col-span-1">
                <input type="password" name="password" placeholder="Password" required minlength="6"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5">
            </div>
            <div class="md:col-span-5">
                <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow transition">
                    + Tambah Teknisi
                </button>
            </div>
        </form>
    </div>

    <!-- List Teknisi -->
    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($technicians as $tech)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $tech->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $tech->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                            {{ ucfirst($tech->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($tech->id == Auth::id())
                            <span class="text-gray-400 italic">Akun Anda</span>
                        @else
                            <form action="{{ route('admin.settings.technicians.delete', $tech->id) }}" method="POST" 
                                onsubmit="return confirm('Yakin ingin menghapus teknisi {{ $tech->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                        Belum ada teknisi terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection