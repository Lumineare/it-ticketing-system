@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Export Laporan Tiket</h1>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-4">Pilih filter untuk mencetak data tiket yang sesuai dengan kebutuhan Anda.</p>
                
                <form action="{{ route('admin.reports.pdf') }}" method="GET" target="_blank" class="mb-3">
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Filter Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="OPEN">OPEN</option>
                                <option value="PROGRESS">PROGRESS</option>
                                <option value="COMPLETE">COMPLETE</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Filter Teknisi</label>
                            <select name="teknisi" class="form-select">
                                <option value="">Semua Teknisi</option>
                                @foreach($technicians as $tech)
                                    <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-block">
                        <button type="submit" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Download PDF</button>
                        <button type="submit" formaction="{{ route('admin.reports.excel') }}" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Download Excel (CSV)</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
