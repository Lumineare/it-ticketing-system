@extends('layouts.app')

@push('styles')
<style>
    .ticket-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        margin-bottom: 3rem;
    }
    
    .table th {
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
        padding: 1rem 1.5rem;
        background: #ffffff;
    }
    
    .table td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .ticket-id { font-weight: 600; color: #0f172a; }
    .ticket-date { color: #94a3b8; font-size: 0.875rem; display: block; margin-top: 0.25rem; }
    .reporter-name { font-weight: 500; color: #1e293b; }
    .reporter-unit { color: #64748b; font-size: 0.85rem; }

    .status-badge { padding: 0.35rem 0.75rem; font-size: 0.75rem; font-weight: 600; border-radius: 6px; letter-spacing: 0.3px; }
    .badge-complete { background-color: #dcfce3; color: #166534; }

    .btn-view { color: #2563eb; font-weight: 500; text-decoration: none; font-size: 0.9rem; transition: color 0.2s; }
    .btn-view:hover { color: #1d4ed8; text-decoration: underline; }

    .pagination-wrapper { padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; background-color: #f8fafc; }
</style>
@endpush

@section('content')
<div class="page-header px-2 border-bottom-0 pb-0">
    <div class="text-start">
        <h2 class="fw-bold text-dark mb-2">Riwayat Laporan Selesai</h2>
        <p class="text-secondary mb-0">Daftar semua laporan teknis yang telah dituntaskan oleh tim IT Support.</p>
    </div>
</div>

<hr class="my-4 opacity-25">

<div class="ticket-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Detail Laporan</th>
                    <th>Pelapor</th>
                    <th>Waktu Penyelesaian</th>
                    <th class="text-end">Aksi Lengkap</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $t)
                <tr>
                    <td>
                        <div class="ticket-id">{{ $t->ticket_id }}</div>
                        <div class="ticket-date"><i class="bi bi-clock me-1"></i> Dilaporkan: {{ $t->waktu_laporan->format('d M Y') }}</div>
                    </td>
                    <td>
                        <div class="reporter-name">{{ $t->nama_pelapor }}</div>
                        <div class="reporter-unit">{{ $t->unit }}</div>
                    </td>
                    <td>
                        <span class="status-badge badge-complete mb-2 d-inline-block"><i class="bi bi-check-circle me-1"></i> COMPLETE</span>
                        <div class="fw-bold text-success" style="font-size:0.9rem;">{{ $t->waktu_selesai ? $t->waktu_selesai->format('d M Y, H:i') : '-' }}</div>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('ticket.show', $t->ticket_id) }}" class="btn-view d-inline-block bg-light border px-3 py-2 rounded-3 shadow-sm text-nowrap">
                            Buka Bukti Cek <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5">
                        <div class="text-muted mb-3">
                            <i class="bi bi-archive fs-1 text-light"></i>
                        </div>
                        <h6 class="text-secondary fw-medium">Belum Ada Riwayat Kerja</h6>
                        <p class="text-muted small mb-0">Halaman ini akan terisi otomatis begitu kendala sudah diperbaiki oleh teknisi.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($tickets->hasPages())
    <div class="pagination-wrapper mb-0 pb-0">
        {{ $tickets->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
