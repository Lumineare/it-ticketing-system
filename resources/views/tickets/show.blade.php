@extends('layouts.app')

@section('content')
<div class="page-header px-2 border-bottom-0 pb-0">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold text-dark mb-2">Detail Laporan</h2>
            <p class="text-secondary mb-0">Rincian tiket keluhan yang telah disubmit.</p>
        </div>
        <a href="/" class="btn btn-outline-secondary btn-sm shadow-sm px-3 rounded-pill">
            <i class="bi bi-arrow-left"></i> Kembali Laman Utama
        </a>
    </div>
</div>

<hr class="my-4 opacity-25">

<div class="card-custom mb-5">
    <div class="card-header bg-light py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-ticket-detailed me-2 text-primary"></i> Laporan: {{ $ticket->ticket_id }}</h5>
        <div>
            @if($ticket->status == 'OPEN')
                <span class="badge bg-warning text-dark status-badge px-3 py-2 rounded-pill"><i class="bi bi-record-circle me-1"></i> OPEN</span>
            @elseif($ticket->status == 'PROGRESS')
                <span class="badge bg-info text-dark status-badge px-3 py-2 rounded-pill"><i class="bi bi-arrow-repeat me-1"></i> PROGRESS</span>
            @elseif($ticket->status == 'COMPLETE')
                <span class="badge bg-success status-badge px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> COMPLETE</span>
            @endif
        </div>
    </div>
    
    <div class="card-body p-4 p-md-5">
        <div class="row gx-5">
            <div class="col-lg-7">
                <h6 class="text-uppercase text-primary fw-bold mb-3 small" style="letter-spacing: 0.5px;">Informasi Keluhan</h6>
                
                <div class="mb-4">
                    <span class="d-block text-muted small mb-1">Nama Pelapor</span>
                    <span class="fw-medium text-dark">{{ $ticket->nama_pelapor }}</span>
                </div>
                
                <div class="mb-4">
                    <span class="d-block text-muted small mb-1">Asal Unit / Dept</span>
                    <span class="fw-medium text-dark">{{ $ticket->unit }}</span>
                </div>
                
                <div class="mb-4">
                    <span class="d-block text-muted small mb-1">Deskripsi Kerusakan / Kendala</span>
                    <p class="text-dark bg-white border p-3 rounded-3 shadow-sm mb-0 lh-lg" style="font-size: 0.95rem;">
                        {{ \Illuminate\Support\Str::limit($ticket->deskripsi_kerusakan, 500) }}
                    </p>
                </div>
                
                @if($ticket->foto)
                <div class="mb-4">
                    <span class="d-block text-muted small mb-2">Foto Pendukung / Screenshot</span>
                    <a href="{{ asset('storage/' . $ticket->foto) }}" target="_blank" class="d-inline-flex align-items-center btn btn-light border text-secondary px-3 py-2 shadow-sm rounded-3">
                        <i class="bi bi-image text-primary me-2"></i> Klik Untuk Membuka Foto
                    </a>
                </div>
                @endif
            </div>
            
            <div class="col-lg-5 mt-5 mt-lg-0">
                <div class="bg-light p-4 rounded-4 border">
                    <h6 class="text-uppercase text-secondary fw-bold mb-4 small" style="letter-spacing: 0.5px;"><i class="bi bi-info-square me-2"></i> Status Perbaikan</h6>
                    
                    <div class="mb-4">
                        <span class="d-block text-muted small mb-1">Tanggal Dilaporkan</span>
                        <span class="fw-bold text-dark"><i class="bi bi-calendar-event me-1"></i> {{ $ticket->waktu_laporan->format('d M Y') }} &nbsp; <i class="bi bi-clock ms-2 me-1"></i> {{ $ticket->waktu_laporan->format('H:i') }}</span>
                    </div>

                    <div class="mb-4 border-bottom pb-4">
                        <span class="d-block text-muted small mb-1">Kategori / Jenis Trouble</span>
                        <span class="badge bg-secondary text-white fw-normal">{{ $ticket->jenis_trouble ?? 'Belum Dinilai' }}</span>
                    </div>

                    <div class="mb-4">
                        <span class="d-block text-muted small mb-1">Ditugaskan Kepada Teknisi</span>
                        <span class="fw-bold {{ $ticket->user ? 'text-primary' : 'text-danger' }}">
                            @if($ticket->user)
                                <i class="bi bi-person-badge me-1"></i> {{ $ticket->user->name }}
                            @else
                                <i class="bi bi-person-x me-1"></i> Belum Ada Tim
                            @endif
                        </span>
                    </div>
                    
                    <div class="mb-4">
                        <span class="d-block text-muted small mb-1">Catatan / Note dari Teknisi</span>
                        <div class="text-dark bg-white border p-3 rounded-3 shadow-sm fst-italic">
                            {{ $ticket->note_perbaikan ?? 'Belum ada catatan perbaikan yang diberikan.' }}
                        </div>
                    </div>

                    @if($ticket->status == 'COMPLETE' && $ticket->waktu_selesai)
                    <div class="mt-4 pt-3 border-top">
                        <span class="d-block text-success small mb-1 fw-bold"><i class="bi bi-check2-all me-1"></i> WAKTU SELESAI PENGERJAAN</span>
                        <span class="fw-bold text-dark fs-5">{{ $ticket->waktu_selesai->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
