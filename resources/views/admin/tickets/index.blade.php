@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Manage Tickets</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <a href="{{ route('admin.reports.excel', request()->all()) }}" class="btn btn-sm btn-outline-success">Export Excel</a>
      <a href="{{ route('admin.reports.pdf', request()->all()) }}" class="btn btn-sm btn-outline-danger">Export PDF</a>
    </div>
  </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.tickets.index') }}" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Cari ID/Pelapor/Unit" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="OPEN" {{ request('status') == 'OPEN' ? 'selected' : '' }}>OPEN</option>
                    <option value="PROGRESS" {{ request('status') == 'PROGRESS' ? 'selected' : '' }}>PROGRESS</option>
                    <option value="COMPLETE" {{ request('status') == 'COMPLETE' ? 'selected' : '' }}>COMPLETE</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="teknisi" class="form-select">
                    <option value="">Semua Teknisi</option>
                    @foreach($technicians as $tech)
                        <option value="{{ $tech->id }}" {{ request('teknisi') == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID Tiket</th>
                <th>Tanggal</th>
                <th>Pelapor</th>
                <th>Unit</th>
                <th>Prioritas</th>
                <th>Teknisi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $t)
            <tr>
                <td>{{ $t->ticket_id }}</td>
                <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                <td>{{ $t->nama_pelapor }}</td>
                <td>{{ $t->unit }}</td>
                <td>
                    @if($t->prioritas == 'Critical' || $t->prioritas == 'High')
                        <span class="badge bg-danger">{{ $t->prioritas }}</span>
                    @elseif($t->prioritas == 'Medium')
                        <span class="badge bg-warning text-dark">{{ $t->prioritas }}</span>
                    @else
                        <span class="badge bg-secondary">{{ $t->prioritas ?? '-' }}</span>
                    @endif
                </td>
                <td>{{ $t->user ? $t->user->name : '-' }}</td>
                <td>
                    @if($t->status == 'OPEN')
                        <span class="badge bg-warning text-dark">OPEN</span>
                    @elseif($t->status == 'PROGRESS')
                        <span class="badge bg-info text-dark">PROGRESS</span>
                    @else
                        <span class="badge bg-success">COMPLETE</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.tickets.show', $t->id) }}" class="btn btn-sm btn-primary">Lihat / Edit</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-3">Belum ada data tiket.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $tickets->links('pagination::bootstrap-5') }}
</div>
@endsection
