@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Histori Tiket (Selesai)</h1>
</div>

<!-- Filter & Search Block -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.tickets.completed') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-muted small">Cari Tiket / Pelapor</label>
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="ID Tiket, Nama, Unit..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Cari</button>
                </div>
            </div>
            <div class="col-md-auto ms-auto">
                <a href="{{ route('admin.tickets.completed') }}" class="btn btn-outline-secondary">Reset Tampilan</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID Tiket</th>
                        <th>Waktu Selesai</th>
                        <th>Pelapor</th>
                        <th>Prioritas</th>
                        <th>Teknisi</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $ticket->ticket_id }}</td>
                        <td>
                            @if($ticket->waktu_selesai)
                                {{ $ticket->waktu_selesai->format('d M Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $ticket->nama_pelapor }}</div>
                            <small class="text-muted">{{ $ticket->unit }}</small>
                        </td>
                        <td>
                            @if($ticket->prioritas == 'Critical')
                                <span class="badge bg-danger">Critical</span>
                            @elseif($ticket->prioritas == 'High')
                                <span class="badge bg-warning text-dark">High</span>
                            @elseif($ticket->prioritas == 'Medium')
                                <span class="badge bg-primary">Medium</span>
                            @elseif($ticket->prioritas == 'Low')
                                <span class="badge bg-secondary">Low</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $ticket->user ? $ticket->user->name : '-' }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">Riwayat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada histori tiket yang selesai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-top-0 pt-3">
        {{ $tickets->links() }}
    </div>
</div>
@endsection
