@extends('layouts.public-app') {{-- Pastikan layouts/public-app.blade.php memiliki background gelap --}}

@section('content')
<!-- Container Utama -->
<div class="min-h-screen bg-gray-900 text-gray-100 p-6">
    
    <!-- Header Dashboard -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Manajemen Tiket</h1>
            <p class="text-gray-400 mt-1 text-sm">Kelola semua tiket support layanan IT</p>
        </div>
        <div class="flex gap-3">
                <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white"></h1>
            <p class="text-gray-400 mt-1 text-sm"></p>
        </div>
        
        <div class="flex flex-wrap gap-3">

            {{-- TOMBOL KELOLA UNIT --}}
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.settings.units') }}" class="bg-gray-700 hover:bg-gray-600 text-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition border border-gray-600 flex items-center gap-2">
                         Kelola Unit
                    </a>
                    
                    <a href="{{ route('admin.settings.technicians') }}" class="bg-gray-700 hover:bg-gray-600 text-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition border border-gray-600 flex items-center gap-2">
                         Kelola Teknisi
                    </a>
                @endif
            @endauth
        </div>
    </div>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('tickets.public.index') }}" class="bg-gray-800 hover:bg-gray-700 text-gray-300 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 border border-gray-700">
                         History Tiket
                    </a>
                    <a href="{{ route('tickets.public.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-lg shadow-blue-500/30">
                        + Tiket Baru
                    </a>
                @endif
            @else
                <a href="{{ route('admin.login') }}" class="text-gray-400 hover:text-white text-sm px-4 py-2 rounded-lg border border-gray-700 transition">Login Staff</a>
            @endauth
        </div>
    </div>

    <!-- Notifikasi Sukses/Error -->
    @if (session('success'))
        <div class="mb-6 bg-green-900/50 border-l-4 border-green-500 p-4 rounded-lg shadow-md backdrop-blur-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="font-medium text-green-300">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-900/50 border-l-4 border-red-500 p-4 rounded-lg shadow-md backdrop-blur-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                <p class="font-medium text-red-300">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Panel Filter & Pencarian -->
    <div class="bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-700 mb-8">
        <form action="{{ route('tickets.public.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            
            <!-- Kolom 1: Cari Tiket -->
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-400 mb-1 uppercase tracking-wider">Cari Tiket / Judul</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="No. Tiket / Judul..." 
                        class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    <svg class="w-5 h-5 text-gray-500 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <!-- Kolom 2: Status -->
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1 uppercase tracking-wider">Status</label>
                <select name="status" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition appearance-none">
                    <option value="">Semua Status</option>
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <!-- Kolom 3: Prioritas -->
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1 uppercase tracking-wider">Prioritas</label>
                <select name="priority" class="w-full bg-gray-900 border border-gray-700 text-gray-100 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition appearance-none">
                    <option value="">Semua Prioritas</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <!-- Tombol Cari & Reset -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition shadow-lg shadow-blue-500/20">
                     Cari
                </button>
                <a href="{{ route('tickets.public.index') }}" class="px-4 py-2.5 bg-gray-700 hover:bg-gray-600 text-gray-300 rounded-lg transition">
                    ↻
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Tiket -->
    <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-16">No.</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-32">Kode</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Judul / Deskripsi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Unit</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Prioritas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-40">Dibuat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-20">Komentar</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($tickets as $index => $ticket)
                        <tr class="hover:bg-gray-750 transition duration-150 {{ $lastCreatedId == $ticket->id ? 'bg-blue-900/20' : '' }}">
                            
                            <!-- No Urut -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $tickets->firstItem() + $index }}
                            </td>

                            <!-- Kode Unik -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-blue-400 font-bold text-sm">{{ $ticket->tracking_code }}</span>
                                @if($lastCreatedId == $ticket->id)
                                    <span class="block text-[10px] text-blue-300 mt-0.5">Baru</span>
                                @endif
                            </td>

                            <!-- Judul & Deskripsi -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-white truncate max-w-xs" title="{{ $ticket->subject }}">{{ Str::limit($ticket->subject, 40) }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs" title="{{ $ticket->description }}">{{ Str::limit($ticket->description, 30) }}</div>
                            </td>

                            <!-- Unit -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-indigo-500 mr-2"></div>
                                    <span class="text-sm text-gray-300">{{ $ticket->unit ? $ticket->unit->name : 'Umum' }}</span>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border 
                                    {{ $ticket->status == 'open' ? 'bg-yellow-900/30 text-yellow-400 border-yellow-700' : '' }}
                                    {{ $ticket->status == 'in_progress' ? 'bg-blue-900/30 text-blue-400 border-blue-700' : '' }}
                                    {{ $ticket->status == 'resolved' ? 'bg-green-900/30 text-green-400 border-green-700' : '' }}
                                    {{ $ticket->status == 'closed' ? 'bg-gray-700 text-gray-400 border-gray-600' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </td>

                            <!-- Prioritas -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $ticket->priority == 'high' ? 'bg-red-900/30 text-red-400' : '' }}
                                    {{ $ticket->priority == 'medium' ? 'bg-orange-900/30 text-orange-400' : '' }}
                                    {{ $ticket->priority == 'low' ? 'bg-green-900/30 text-green-400' : '' }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>

                            <!-- Dibuat -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $ticket->created_at->format('d M Y') }}
                            </td>

                            <!-- Komentar (Placeholder) -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-700 text-xs text-gray-300">
                                    0
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('tickets.public.show', $ticket) }}" class="text-blue-400 hover:text-blue-300 transition p-1" title="Proses/Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                    <a href="#" class="text-gray-400 hover:text-gray-300 transition p-1" title="Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    <p class="text-gray-400 text-lg">Belum ada laporan masuk.</p>
                                    <p class="text-gray-500 text-sm mt-1">Silakan buat tiket baru untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-gray-800 px-4 py-3 border-t border-gray-700 sm:px-6">
            {{ $tickets->links() }}
        </div>
    </div>
</div>
@endsection