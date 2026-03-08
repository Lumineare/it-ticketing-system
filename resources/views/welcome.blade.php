@extends('layouts.app')

@push('styles')
<style>
    /* Ticket List Card overrides */
    .ticket-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        margin-bottom: 3rem;
    }
    
    .ticket-list-header {
        padding: 1.25rem 1.5rem;
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .ticket-list-header h5 {
        margin: 0;
        font-weight: 600;
        color: #1e293b;
        font-size: 1.1rem;
    }

    /* Table Styling */
    .table {
        margin-bottom: 0;
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
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .ticket-id {
        font-weight: 600;
        color: #0f172a;
    }
    .ticket-date {
        color: #94a3b8;
        font-size: 0.875rem;
        display: block;
        margin-top: 0.25rem;
    }
    .reporter-name {
        font-weight: 500;
        color: #1e293b;
    }
    .reporter-unit {
        color: #64748b;
        font-size: 0.85rem;
    }

    /* Badges */
    .status-badge {
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        letter-spacing: 0.3px;
    }
    .badge-open {
        background-color: #fef3c7;
        color: #b45309;
    }
    .badge-progress {
        background-color: #e0f2fe;
        color: #0369a1;
    }
    .badge-complete {
        background-color: #dcfce3;
        color: #166534;
    }

    /* Action Link */
    .btn-view {
        color: #2563eb;
        font-weight: 500;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.2s;
    }
    .btn-view:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    .pagination-wrapper {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e2e8f0;
        background-color: #f8fafc;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="page-header px-2 border-bottom-0 pb-0">
    <!-- Di sidebar layout, hero header bisa sedikit dikecilkan ukurannya jadi left-aligned -->
    <div class="text-start">
        <h1 class="display-5 fw-bold text-dark mb-3">Pusat Bantuan IT</h1>
        <p class="lead text-secondary mb-4" style="max-width: 700px;">
            Sistem layanan pelaporan kendala IT terpadu. Laporkan masalah perangkat keras, jaringan, atau sistem perangkat lunak Anda untuk mendapatkan resolusi yang cepat.
        </p>
        <a href="{{ route('ticket.create') }}" class="btn btn-primary btn-lg shadow-sm rounded-pill px-4">
            <i class="bi bi-plus-circle me-1"></i> Buat Laporan Baru
        </a>
    </div>
</div>

<hr class="my-5 opacity-25">

<!-- Ticket List Container -->
<div class="ticket-card">
    <div class="ticket-list-header d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h5>Antrean Tiket Aktif</h5>
            <span class="text-muted small d-block mt-1">Status <strong>OPEN</strong>, <strong>PROGRESS</strong>, dan tiket yang diselesaikan hari ini.</span>
        </div>
        <a href="{{ route('tickets.completed') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-archive me-1"></i> Riwayat Historis
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Detail Laporan</th>
                    <th>Pelapor</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $t)
                <tr>
                    <td>
                        <div class="ticket-id">{{ $t->ticket_id }}</div>
                        <div class="ticket-date"><i class="bi bi-clock me-1"></i> {{ $t->waktu_laporan->diffForHumans() }} ({{ $t->waktu_laporan->format('d M') }})</div>
                    </td>
                    <td>
                        <div class="reporter-name">{{ $t->nama_pelapor }}</div>
                        <div class="reporter-unit">{{ $t->unit }}</div>
                    </td>
                    <td>
                        @if($t->status == 'OPEN')
                            <span class="status-badge badge-open"><i class="bi bi-record-circle me-1"></i> OPEN</span>
                        @elseif($t->status == 'PROGRESS')
                            <span class="status-badge badge-progress"><i class="bi bi-arrow-repeat me-1"></i> PROGRESS</span>
                        @else
                            <span class="status-badge badge-complete"><i class="bi bi-check-circle me-1"></i> COMPLETE</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('ticket.show', $t->ticket_id) }}" class="btn-view text-nowrap">
                            Detail <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5">
                        <div class="text-muted mb-3">
                            <i class="bi bi-inbox fs-1 text-light"></i>
                        </div>
                        <h6 class="text-secondary fw-medium">Antrean Kosong</h6>
                        <p class="text-muted small mb-0">Saat ini tidak ada laporan tiket yang sedang berjalan.</p>
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
