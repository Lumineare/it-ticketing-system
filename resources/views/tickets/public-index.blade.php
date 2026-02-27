@extends('layouts.public-app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">SI MRT-IT</h1>
            <p class="text-gray-600 mt-1">Sistem Informasi Maintenance Request And Trouble IT</p>
        </div>
        
        <div class="flex gap-3 items-center">
            
            @auth
                {{-- JIKA SUDAH LOGIN SEBAGAI ADMIN --}}
                @if(Auth::user()->role === 'admin')
                    <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium self-center hidden md:inline-block">
                        Mode Admin
                    </span>
                    
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                            Logout
                        </button>
                    </form>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.settings.units') }}" class="text-xs bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded">Kelola Unit</a>
                        <a href="{{ route('admin.settings.technicians') }}" class="text-xs bg-gray-200 hover:bg-gray-300 px-2 py-1 rounded">Kelola Teknisi</a>
                    </div>
                @endif
            @else
                {{-- JIKA BELUM LOGIN --}}
                <a href="{{ route('admin.login') }}" class="text-gray-500 hover:text-indigo-600 text-sm font-medium border border-gray-300 px-4 py-2 rounded-md hover:border-indigo-300 transition">
                    Login Staff IT
                </a>
            @endauth

            <a href="{{ route('tickets.public.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium shadow-sm transition">
                + Buat Laporan
            </a>
        </div>
    </div>

    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-bold text-green-800">{{ session('success') }}</p>
                    <p class="text-sm text-green-700 mt-1">Tiket Anda telah ditandai dengan garis biru di bawah.</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700">&times;</button>
            </div>
        </div>
    @endif

    <!-- Tabel Daftar Tiket -->
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Kode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Start Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi Laporan</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note Pelaksana IT</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">End Date</th>
                        
                        {{-- Kolom Aksi Admin --}}
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <th class="px-4 py-3 text-center text-xs font-medium text-indigo-600 uppercase tracking-wider w-24">Aksi Admin</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tickets as $index => $ticket)
                        <tr class="{{ $lastCreatedId == $ticket->id ? 'bg-blue-50' : 'hover:bg-gray-50' }}">
                            
                            <!-- 1. No -->
                            <td class="px-4 py-3 text-center text-gray-700 font-medium">
                                {{ $tickets->firstItem() + $index }}
                            </td>

                            <!-- 2. Kode -->
                            <td class="px-4 py-3 text-left">
                                <span class="font-mono font-bold text-indigo-700">{{ $ticket->tracking_code }}</span>
                                @if($lastCreatedId == $ticket->id)
                                    <span class="block text-xs text-blue-600 mt-1 font-semibold">Baru</span>
                                @endif
                            </td>

                            <!-- 3. Start Date -->
                            <td class="px-4 py-3 text-left text-gray-600 whitespace-nowrap">
                                <div class="font-medium">{{ $ticket->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $ticket->created_at->format('H:i:s') }}</div>
                                <div class="text-xs text-gray-400">{{ $ticket->created_at->format('l') }}</div>
                            </td>

                            <!-- 4. Deskripsi & UNIT -->
                            <td class="px-4 py-3 text-left text-gray-700 max-w-xs">
                                <div class="font-medium text-gray-900 mb-1">{{ Str::limit($ticket->subject, 40) }}</div>
                                <div class="text-xs text-gray-500 line-clamp-2" title="{{ $ticket->description }}">
                                    {{ Str::limit($ticket->description, 80) }}
                                </div>
                                
                                <div class="flex flex-wrap gap-2 mt-2 items-center">
                                    @if($ticket->unit)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">
                                            🏢 {{ $ticket->unit->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                            🏢 Umum
                                        </span>
                                    @endif
                                    <span class="text-xs text-gray-400">• {{ $ticket->reporter_name }}</span>
                                </div>
                            </td>

                            <!-- 5. Status -->
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $ticket->status == 'open' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $ticket->status == 'in_progress' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $ticket->status == 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $ticket->status == 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </td>

                            <!-- 6. Note -->
                            <td class="px-4 py-3 text-left text-gray-600">
                                @if($ticket->technician_note)
                                    <div class="text-xs bg-gray-50 border border-gray-200 p-2 rounded italic">
                                        "{{ Str::limit($ticket->technician_note, 60) }}"
                                    </div>
                                @else
                                    <span class="text-gray-300 text-xs">-</span>
                                @endif
                            </td>

                            <!-- 7. End Date -->
                            <td class="px-4 py-3 text-left text-gray-600 whitespace-nowrap">
                                @if($ticket->resolved_at)
                                    <div class="font-medium text-green-700">{{ $ticket->resolved_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $ticket->resolved_at->format('H:i:s') }}</div>
                                    <div class="text-xs text-gray-400">{{ $ticket->resolved_at->format('l') }}</div>
                                @else
                                    <span class="text-gray-300 text-xs">Belum Selesai</span>
                                @endif
                            </td>

                            {{-- 8. Tombol Aksi Admin --}}
                            @auth
                                @if(Auth::user()->role === 'admin')
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('tickets.public.show', $ticket) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded shadow transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Proses
                                    </a>
                                </td>
                                @endif
                            @endauth
                        </tr>
                    @empty
                        <tr>
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <td colspan="8" class="px-4 py-10 text-center text-gray-500">Belum ada laporan masuk.</td>
                                @else
                                    <td colspan="7" class="px-4 py-10 text-center text-gray-500">Belum ada laporan masuk.</td>
                                @endif
                            @else
                                <td colspan="7" class="px-4 py-10 text-center text-gray-500">Belum ada laporan masuk.</td>
                            @endauth
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $tickets->links() }}
        </div>
    </div>
</div>
@endsection