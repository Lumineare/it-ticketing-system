<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Masalah IT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-4xl mx-auto px-4 py-4">
            <h1 class="text-xl font-bold text-gray-800">MRT IT- Lapor Masalah</h1>
        </div>
    </nav>

    <main class="flex-grow py-10">
        <div class="max-w-2xl mx-auto px-4">
            
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-indigo-50 border-b border-indigo-100">
                    <h2 class="text-lg font-bold text-indigo-900">SI MRT-IT</h2>
                    <p class="text-sm text-indigo-700">MAINTENANCE/REQUEST/TROUBLE - IT</p>
                </div>

                <form action="{{ route('tickets.public.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    
                    <!-- Identitas Pelapor -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" name="reporter_name" value="{{ old('reporter_name') }}" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5">
                            @error('reporter_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                            <select name="unit_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5 bg-white">
                            <option value="">-- Pilih Unit Anda --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->name }}
                            </option>
                            @endforeach
                            </select>
                            @error('unit_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Jika unit Anda belum ada, silakan hubungi admin IT.</p>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- Detail Tiket -->

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                        <select name="priority" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5 bg-white">
                            <option value="low">Low (Tidak Mendesak)</option>
                            <option value="medium" selected>Medium (Mengganggu Pekerjaan)</option>
                            <option value="high">High (Darurat / Stop Operasi)</option>
                        </select>
                        @error('priority') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Detail</label>
                        <textarea name="description" rows="5" required placeholder="Jelaskan masalah secara detail..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2.5">{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                <!-- Tombol Batal -->
                <a href="{{ route('tickets.public.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm">
                    Batal
                </a>
                
                <!-- Tombol Kirim -->
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition">
                    Kirim Laporan
                </button>
        </div>
    </main>
</body>
</html>