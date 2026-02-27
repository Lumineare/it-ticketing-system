@extends('layouts.public-app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Unit Kerja</h1>
        <a href="{{ route('tickets.public.index') }}" class="text-sm text-gray-500 hover:text-indigo-600">
            ← Kembali ke Dashboard
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
            <p class="font-bold text-green-800">{{ session('success') }}</p>
        </div>
    @endif
    
    <!-- Form Tambah Unit -->
    <div class="bg-white p-6 rounded-lg shadow mb-8 border border-gray-200">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Unit Baru</h2>
        <form action="{{ route('admin.settings.units.store') }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="name" placeholder="Nama Unit (misal: Keuangan, HRD)" required 
                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow transition">
                Tambah
            </button>
        </form>
    </div>

    <!-- List Unit -->
    <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Unit</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($units as $unit)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $unit->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <form action="{{ route('admin.settings.units.delete', $unit->id) }}" method="POST" 
                            onsubmit="return confirm('Hapus unit {{ $unit->name }}? Pastikan tidak ada tiket aktif dari unit ini.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="px-6 py-10 text-center text-gray-500">
                        Belum ada unit terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection