@extends('layouts.public-app')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="{{ route('tickets.public.index') }}" class="text-gray-400 hover:text-white flex items-center gap-2 text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            ← Kembali ke Daftar
        </a>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Informasi Tiket (Untuk Semua Orang) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Card Utama Tiket -->
            <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 overflow-hidden">
                <div class="px-6 py-5 bg-gray-900 border-b border-gray-700 flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ $ticket->subject }}</h2>
                        <p class="text-sm text-gray-400 mt-1">
                            Kode: <span class="font-mono text-blue-400 font-bold">{{ $ticket->tracking_code }}</span> • 
                            Dilapor oleh {{ $ticket->reporter_name }}
                        </p>
                    </div>
                    <span class="px-3 py-1 text-sm font-bold rounded-full 
                        {{ $ticket->status == 'open' ? 'bg-yellow-900/30 text-yellow-400 border border-yellow-700' : '' }}
                        {{ $ticket->status == 'in_progress' ? 'bg-blue-900/30 text-blue-400 border border-blue-700' : '' }}
                        {{ $ticket->status == 'resolved' ? 'bg-green-900/30 text-green-400 border border-green-700' : '' }}
                        {{ $ticket->status == 'closed' ? 'bg-gray-700 text-gray-400 border border-gray-600' : '' }}">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                </div>

                <div class="p-6">
                    <h3 class="text-sm font-medium text-gray-400 uppercase tracking-wide mb-2">Deskripsi Masalah</h3>
                    <div class="text-gray-100 whitespace-pre-line leading-relaxed bg-gray-900 p-4 rounded-lg border border-gray-700">
                        {{ $ticket->description }}
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-900 border-t border-gray-700 text-sm text-gray-400 flex justify-between items-center">
                    <span>Prioritas: <span class="font-bold text-white capitalize ml-1">{{ $ticket->priority }}</span></span>
                    <span>Dibuat: {{ $ticket->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
            
            <!-- Catatan Teknisi Publik -->
            <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 p-6">
                <h3 class="text-lg font-bold text-white mb-2">Catatan Teknisi</h3>
                @if($ticket->assignedTechnician)
                    <p class="text-sm text-gray-400 mb-2">Ditangani oleh: <span class="font-medium text-blue-400">{{ $ticket->assignedTechnician->name }}</span></p>
                @endif
                
                @if($ticket->technician_note)
                    <div class="bg-gray-900 border border-gray-700 rounded-lg p-4 text-sm text-gray-300 italic">
                        "{{ $ticket->technician_note }}"
                    </div>
                @else
                    <p class="text-gray-500 text-sm italic">Belum ada catatan publik.</p>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: PANEL ADMIN (HANYA MUNCUL JIKA LOGIN SEBAGAI ADMIN) -->
        @auth
            @if(Auth::user()->role === 'admin')
                <div class="lg:col-span-1">
                    <!-- Notifikasi Sukses/Error (Diletakkan di atas panel) -->
                    @if (session('success'))
                        <div class="mb-4 bg-green-900/50 border-l-4 border-green-500 p-4 rounded-lg shadow-md backdrop-blur-sm">
                            <p class="font-bold text-green-300 text-sm">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-900/50 border-l-4 border-red-500 p-4 rounded-lg shadow-md backdrop-blur-sm">
                            <p class="font-bold text-red-300 text-sm">{{ session('error') }}</p>
                        </div>
                    @endif

                    <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 overflow-hidden sticky top-6">
                        <div class="px-5 py-4 bg-gray-900 border-b border-gray-700 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <h3 class="font-bold text-white text-lg">Panel Admin</h3>
                        </div>
                        
                        <form action="{{ route('admin.tickets.updateStatus', $ticket) }}" method="POST" class="p-5 space-y-5">
                            @csrf
                            @method('PATCH')
                            
                            <!-- Catatan Perbaikan -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Catatan Perbaikan (Note)</label>
                                <textarea name="technician_note" rows="3" 
                                    class="w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-all border resize-none"
                                    placeholder="Tulis tindakan perbaikan yang dilakukan...">{{ old('technician_note', $ticket->technician_note) }}</textarea>
                                <p class="text-[10px] text-blue-400 mt-1">Catatan ini akan tampil di daftar laporan publik.</p>
                            </div>

                            <!-- Ubah Status -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Ubah Status</label>
                                <select name="status" class="w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-all border appearance-none cursor-pointer">
                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>

                            <!-- Tugaskan Ke -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Tugaskan Ke</label>
                                <select name="assigned_to" class="w-full rounded-lg border-gray-600 bg-gray-900 text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 transition-all border appearance-none cursor-pointer">
                                    <option value="">-- Belum Ditugaskan --</option>
                                    @foreach($technicians as $tech)
                                        <option value="{{ $tech->id }}" {{ $ticket->assigned_to == $tech->id ? 'selected' : '' }}>
                                            {{ $tech->name }} ({{ $tech->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tombol Simpan -->
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform active:scale-95 shadow-lg shadow-blue-500/30">
                                Simpan Perubahan
                            </button>
                        </form>
                        
                        <div class="px-5 pb-5 pt-0">
                            <p class="text-[10px] text-gray-500 text-center">Hanya staf IT yang dapat mengubah status.</p>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
        
        <!-- Pesan jika bukan admin -->
        @guest
        <div class="lg:col-span-1">
            <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 p-6 text-center h-full flex flex-col justify-center">
                <p class="text-sm text-gray-400 mb-3">Butuh bantuan lebih lanjut atau ingin update status?</p>
                <a href="{{ route('admin.login') }}" class="text-blue-400 hover:text-blue-300 font-medium text-sm underline">Login sebagai Staff IT</a>
            </div>
        </div>
        @endguest
    </div>
</div>
@endsection