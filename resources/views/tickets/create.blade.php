@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('tickets.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 text-sm font-medium">
            ← Kembali ke Daftar Tiket
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Buat Tiket Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Jelaskan masalah IT yang Anda alami secara detail.</p>
        </div>

        <form action="{{ route('tickets.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Subjek -->
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek Masalah</label>
                <input type="text" 
                       name="subject" 
                       id="subject" 
                       value="{{ old('subject') }}"
                       required
                       placeholder="Contoh: Printer Ruang Rapat Tidak Bisa Connect"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5 @error('subject') border-red-500 @enderror">
                @error('subject')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prioritas -->
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Tingkat Prioritas</label>
                <select name="priority" id="priority" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5 bg-white @error('priority') border-red-500 @enderror">
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low (Rendah) - Tidak mendesak</option>
                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }} selected>Medium (Sedang) - Mengganggu pekerjaan</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High (Tinggi) - Pekerjaan terhenti total</option>
                </select>
                @error('priority')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Detail</label>
                <textarea name="description" 
                          id="description" 
                          rows="5" 
                          required
                          placeholder="Jelaskan kronologi masalah, pesan error yang muncul, dan langkah yang sudah dicoba..."
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('tickets.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm">
                    Kirim Tiket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection