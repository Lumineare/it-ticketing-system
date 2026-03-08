@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Detail Tiket: {{ $ticket->ticket_id }}</h1>
  <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">Informasi Laporan</div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><td width="30%" class="text-muted">Nama Pelapor</td><td>: <strong>{{ $ticket->nama_pelapor }}</strong></td></tr>
                    <tr><td class="text-muted">Asal Unit / Dept</td><td>: {{ $ticket->unit }}</td></tr>
                    <tr><td class="text-muted">Waktu Pelaporan</td><td>: {{ $ticket->waktu_laporan->format('d M Y H:i') }}</td></tr>
                    <tr><td class="text-muted">Deskripsi Kerusakan</td><td>: <br><p class="mt-2 text-dark bg-light p-3 rounded">{{ $ticket->deskripsi_kerusakan }}</p></td></tr>
                    @if($ticket->foto)
                    <tr><td class="text-muted">Foto Pendukung</td><td>: <a href="{{ asset('storage/' . $ticket->foto) }}" target="_blank" class="btn btn-sm btn-outline-info">Lihat Foto</a></td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">Update Status Tiket</div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($ticket->status === 'COMPLETE')
                    <div class="alert alert-success text-center">
                        <h5 class="mb-1"><i class="bi bi-check-circle-fill"></i> Selesai</h5>
                        <small>Tiket ini telah selesai dan tidak dapat diubah lagi.</small>
                    </div>
                @else
                <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select text-uppercase" required>
                            @if($ticket->status === 'OPEN')
                                <option value="OPEN" selected>OPEN</option>
                                <option value="PROGRESS">PROGRESS</option>
                                <option value="COMPLETE">COMPLETE</option>
                            @elseif($ticket->status === 'PROGRESS')
                                <option value="PROGRESS" selected>PROGRESS</option>
                                <option value="COMPLETE">COMPLETE</option>
                            @endif
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Prioritas</label>
                        <select name="prioritas" class="form-select">
                            <option value="">- Set Prioritas -</option>
                            <option value="Low" {{ $ticket->prioritas == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ $ticket->prioritas == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ $ticket->prioritas == 'High' ? 'selected' : '' }}>High</option>
                            <option value="Critical" {{ $ticket->prioritas == 'Critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Trouble</label>
                        <select name="jenis_trouble" class="form-select">
                            <option value="">- Kategori -</option>
                            <option value="Hardware" {{ $ticket->jenis_trouble == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                            <option value="Software" {{ $ticket->jenis_trouble == 'Software' ? 'selected' : '' }}>Software</option>
                            <option value="Network" {{ $ticket->jenis_trouble == 'Network' ? 'selected' : '' }}>Network</option>
                            <option value="Komunikasi" {{ $ticket->jenis_trouble == 'Komunikasi' ? 'selected' : '' }}>Komunikasi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teknisi Penanganan</label>
                        <select name="teknisi" class="form-select">
                            <option value="">- Pilih Teknisi -</option>
                            @foreach($technicians as $tech)
                                <option value="{{ $tech->id }}" {{ $ticket->teknisi == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Note Perbaikan</label>
                        <textarea name="note_perbaikan" class="form-control" rows="3">{{ $ticket->note_perbaikan }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tindakan Lanjutan (Opsional)</label>
                        <textarea name="tindakan_lanjutan" class="form-control" rows="2">{{ $ticket->tindakan_lanjutan }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
