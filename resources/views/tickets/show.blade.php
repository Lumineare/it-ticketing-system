@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Tombol Kembali -->
    <div class="mb-6">
        <!-- PERBAIKAN: Ganti tickets.index jadi admin.dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 text-sm font-medium">
            ← Kembali ke Daftar Tiket
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Detail Tiket -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $ticket->subject }}</h2>
                        <!-- Tampilkan nama pelapor (karena sekarang user tidak login) -->
                        <p class="text-sm text-gray-500 mt-1">
                            Dilapor oleh: <span class="font-medium text-gray-700">{{ $ticket->reporter_name ?? $ticket->user->name }}</span> 
                            ({{ $ticket->reporter_email ?? $ticket->user->email }})
                            <br>
                            Pada {{ $ticket->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $ticket->priority == 'high' ? 'bg-red-100 text-red-800' : ($ticket->priority == 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($ticket->priority) }} Priority
                    </span>
                </div>

                <div class="p-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Deskripsi Masalah</h3>
                    <div class="text-gray-800 whitespace-pre-line leading-relaxed">
                        {{ $ticket->description }}
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-sm text-gray-600 flex justify-between">
                    <span>ID Tiket: #{{ $ticket->id }}</span>
                    <span>Status Saat Ini: 
                        <span class="font-bold text-indigo-600">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</span>
                    </span>
                </div>
            </div>

            <!-- Area Komentar -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat & Komentar</h3>
                <p class="text-gray-500 text-sm italic">Fitur komentar akan segera ditambahkan.</p>
            </div>
        </div>

        <!-- Kolom Kanan: Panel Admin -->
        @if(Auth::user()->role === 'admin')
        <div class="md:col-span-1">
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden sticky top-6">
                <div class="px-4 py-3 bg-indigo-50 border-b border-indigo-100">
                    <h3 class="font-bold text-indigo-900">Panel Teknisi</h3>
                </div>
                <div class="p-4 space-y-4">
                    
                    <!-- Form Update Status -->
                    <!-- PERBAIKAN: Ganti route updateStatus jadi admin.tickets.updateStatus -->
                    <form action="{{ route('admin.tickets.updateStatus', $ticket) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ubah Status</label>
                            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2 bg-white">
                                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tugaskan Ke</label>
                            <select name="assigned_to" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2 bg-white">
                                <option value="">-- Belum Ditugaskan --</option>
                                <option value="{{ Auth::id() }}" {{ $ticket->assigned_to == Auth::id() ? 'selected' : '' }}>Saya ({{ Auth::user()->name }})</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Status
                        </button>
                    </form>

                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-500">
                            Ditugaskan ke: 
                            <span class="font-medium text-gray-800">
                                {{ $ticket->assignedTechnician ? $ticket->assignedTechnician->name : 'Belum ada' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection