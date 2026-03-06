@extends('layouts.public-app')

@section('content')
<div class="min-h-screen bg-gray-900 text-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        
        <!-- Header Form -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-white tracking-tight">
                Buat Laporan Baru
            </h2>
            <p class="mt-4 text-lg text-gray-400">
                Isi formulir di bawah ini untuk melaporkan masalah IT Anda. Tim kami akan segera menindaklanjuti.
            </p>
        </div>

        <!-- Card Form -->
        <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 overflow-hidden">
                        <form action="{{ route('tickets.public.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                <!-- Nama Pelapor -->
                <div>
                    <!-- Pastikan id="reporter_name" ada di sini -->
                    <label for="reporter_name" class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <!-- Tambahkan id="reporter_name" jika belum ada -->
                        <input type="text" name="reporter_name" id="reporter_name" required 
                            value="{{ old('reporter_name') }}"
                            class="pl-10 block w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-3 px-4 transition-all border"
                            placeholder="Masukkan nama Anda">
                    </div>
                    @error('reporter_name')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <!-- Unit Kerja -->
                <div>
                    <!-- Pastikan id="unit_id" ada di sini -->
                    <label for="unit_id" class="block text-sm font-medium text-gray-300 mb-2">Unit / Divisi Asal</label>
                    <!-- Tambahkan id="unit_id" jika belum ada -->
                    <select name="unit_id" id="unit_id" required 
                        class="block w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-3 px-4 transition-all border appearance-none">
                        <option value="">-- Pilih Unit Anda --</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>
                <!-- Deskripsi -->
                <div>
                    <!-- Pastikan id="description" ada di sini -->
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi Detail</label>
                    <!-- Tambahkan id="description" jika belum ada -->
                    <textarea name="description" id="description" rows="5" required
                        class="block w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-3 px-4 transition-all border"
                        placeholder="Jelaskan kronologi masalah, pesan error...">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <!-- Prioritas -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Prioritas</label>
                    <div class="grid grid-cols-3 gap-4">
                        
                        <!-- Pilihan Rendah -->
                        <label for="priority_low" class="cursor-pointer relative group">
                            <input type="radio" name="priority" id="priority_low" value="low" {{ old('priority') == 'low' ? 'checked' : '' }} class="peer sr-only">
                            <div class="rounded-lg border border-gray-600 bg-gray-900 p-4 text-center peer-checked:bg-blue-600 peer-checked:border-blue-500 peer-checked:text-white transition-all hover:bg-gray-800 group-hover:border-gray-500">
                                <span class="block text-xs font-bold uppercase text-gray-400 peer-checked:text-white">Rendah</span>
                                <span class="block text-sm font-medium text-gray-300 peer-checked:text-white">Biasa</span>
                            </div>
                        </label>

                        <!-- Pilihan Sedang -->
                        <label for="priority_medium" class="cursor-pointer relative group">
                            <input type="radio" name="priority" id="priority_medium" value="medium" {{ old('priority') == 'medium' ? 'checked' : '' }} class="peer sr-only">
                            <div class="rounded-lg border border-gray-600 bg-gray-900 p-4 text-center peer-checked:bg-orange-600 peer-checked:border-orange-500 peer-checked:text-white transition-all hover:bg-gray-800 group-hover:border-gray-500">
                                <span class="block text-xs font-bold uppercase text-gray-400 peer-checked:text-white">Sedang</span>
                                <span class="block text-sm font-medium text-gray-300 peer-checked:text-white">Penting</span>
                            </div>
                        </label>

                        <!-- Pilihan Tinggi -->
                        <label for="priority_high" class="cursor-pointer relative group">
                            <input type="radio" name="priority" id="priority_high" value="high" {{ old('priority') == 'high' ? 'checked' : '' }} class="peer sr-only">
                            <div class="rounded-lg border border-gray-600 bg-gray-900 p-4 text-center peer-checked:bg-red-600 peer-checked:border-red-500 peer-checked:text-white transition-all hover:bg-gray-800 group-hover:border-gray-500">
                                <span class="block text-xs font-bold uppercase text-gray-400 peer-checked:text-white">Tinggi</span>
                                <span class="block text-sm font-medium text-gray-300 peer-checked:text-white">Darurat</span>
                            </div>
                        </label>

                    </div>
                    @error('priority')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-700">
                    <button type="submit" class="w-full sm:w-auto flex-1 justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">
                        Kirim Laporan
                    </button>
                    <a href="{{ route('tickets.public.index') }}" class="w-full sm:w-auto flex-1 justify-center bg-gray-700 hover:bg-gray-600 text-gray-200 font-medium py-3 px-6 rounded-lg border border-gray-600 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer Link -->
    </div>
</div>
@endsection