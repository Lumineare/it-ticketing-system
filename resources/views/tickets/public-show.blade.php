@extends('layouts.public-app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('tickets.public.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2 text-sm font-medium">
            ← Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Informasi Tiket (Untuk Semua Orang) -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $ticket->subject }}</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Kode: <span class="font-mono font-medium">{{ $ticket->tracking_code }}</span> • 
                            Dilapor oleh {{ $ticket->reporter_name }}
                        </p>
                    </div>
                    <span class="px-3 py-1 text-sm font-bold rounded-full 
                        {{ $ticket->status == 'open' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $ticket->status == 'in_progress' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $ticket->status == 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $ticket->status == 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                </div>

                <div class="p-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Deskripsi Masalah</h3>
                    <div class="text-gray-800 whitespace-pre-line leading-relaxed bg-gray-50 p-4 rounded border border-gray-100">
                        {{ $ticket->description }}
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-sm text-gray-600 flex justify-between items-center">
                    <span>Prioritas: <span class="font-bold capitalize">{{ $ticket->priority }}</span></span>
                    <span>Dibuat: {{ $ticket->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
            
            <!-- Area Komentar / Catatan Teknisi Publik -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Catatan Teknisi</h3>
                @if($ticket->assignedTechnician)
                    <p class="text-sm text-gray-600 mb-2">Ditangani oleh: <span class="font-medium text-indigo-600">{{ $ticket->assignedTechnician->name }}</span></p>
                @endif
                
                @if($ticket->technician_note)
                    <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm text-gray-700">
                        {{ $ticket->technician_note }}
                    </div>
                @else
                    <p class="text-gray-400 text-sm italic">Belum ada catatan publik.</p>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: PANEL ADMIN (HANYA MUNCUL JIKA LOGIN SEBAGAI ADMIN) -->
        @auth
            @if(Auth::user()->role === 'admin')
            <div class="md:col-span-1">
                <div class="bg-indigo-50 shadow-sm rounded-lg border border-indigo-100 overflow-hidden sticky top-6">
                    <div class="px-4 py-3 bg-indigo-100 border-b border-indigo-200">
                        <h3 class="font-bold text-indigo-900 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Panel Admin
                        </h3>
                    </div>
                    
                    <div class="p-4 space-y-4">
                        <form action="{{ route('admin.tickets.updateStatus', $ticket) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <!-- 1. Catatan Perbaikan -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-indigo-900 mb-1">Catatan Perbaikan (Note)</label>
                                <textarea name="technician_note" rows="3" class="w-full rounded-md border-indigo-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2 bg-white" placeholder="Tulis tindakan perbaikan yang dilakukan...">{{ old('technician_note', $ticket->technician_note) }}</textarea>
                                <p class="text-xs text-indigo-600 mt-1">Catatan ini akan tampil di daftar laporan publik.</p>
                            </div>

                            <!-- 2. Ubah Status (BAGIAN YANG DIPERBAIKI) -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-indigo-900 mb-1">Ubah Status</label>
                                <select name="status" class="w-full rounded-md border-indigo-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2 bg-white cursor-pointer">
                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>

                            <!-- 3. Tugaskan Ke -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-indigo-900 mb-1">Tugaskan Ke</label>
                                <select name="assigned_to" class="w-full rounded-md border-indigo-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2 bg-white">
                                    <option value="">-- Belum Ditugaskan --</option>
                                    <option value="{{ Auth::id() }}" {{ $ticket->assigned_to == Auth::id() ? 'selected' : '' }}>Saya ({{ Auth::user()->name }})</option>
                                </select>
                            </div>

                            <!-- 4. Tombol Simpan -->
                            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition transform active:scale-95">
                                Simpan Perubahan
                            </button>
                        </form>
                        
                        @if(session('success'))
                            <div class="mt-2 p-2 bg-green-100 text-green-700 text-xs rounded text-center font-medium">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <p class="text-xs text-gray-400">Hanya staf IT yang dapat mengubah status.</p>
                </div>
            </div>
            @endif
        @endauth
        
        <!-- Pesan jika bukan admin -->
        @guest
        <div class="md:col-span-1">
            <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 text-center h-full flex flex-col justify-center">
                <p class="text-sm text-gray-500 mb-3">Butuh bantuan lebih lanjut atau ingin update status?</p>
                <a href="{{ route('admin.login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm underline">Login sebagai Staff IT</a>
            </div>
        </div>
        @endguest
    </div>
</div>
@endsection