<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Tiket - IT Ticketing System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .status-badge { font-size: 0.9em; padding: 0.5em 1em; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/">IT Ticketing</a>
  </div>
</nav>

<div class="container mb-5" style="max-width: 800px;">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Berhasil!</h4>
            <p>{{ session('success') }}</p>
            <hr>
            <p class="mb-0">Nomor Tiket Anda: <strong>{{ session('ticket_id_submitted') }}</strong></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0">Cek Status Tiket</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('ticket.check') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-lg" name="ticket_id" placeholder="Masukkan ID Tiket (Contoh: TCK-20231024-0001)" value="{{ request('ticket_id') ?? session('ticket_id_submitted') }}" required>
                    <button class="btn btn-primary px-4" type="submit">Cek Status</button>
                </div>
                @error('ticket_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>

    @if(isset($ticket))
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Tiket: {{ $ticket->ticket_id }}</h5>
            @if($ticket->status == 'OPEN')
                <span class="badge bg-warning text-dark status-badge">OPEN</span>
            @elseif($ticket->status == 'PROGRESS')
                <span class="badge bg-info text-dark status-badge">PROGRESS</span>
            @elseif($ticket->status == 'COMPLETE')
                <span class="badge bg-success status-badge">COMPLETE</span>
            @endif
        </div>
        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-sm-4 text-muted">Tanggal Dilaporkan</div>
                <div class="col-sm-8 fw-bold">{{ $ticket->waktu_laporan->format('d M Y H:i') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 text-muted">Nama Pelapor</div>
                <div class="col-sm-8">{{ $ticket->nama_pelapor }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 text-muted">Asal Unit / Dept</div>
                <div class="col-sm-8">{{ $ticket->unit }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 text-muted">Deskripsi Kerusakan</div>
                <div class="col-sm-8">{{ $ticket->deskripsi_kerusakan }}</div>
            </div>
            @if($ticket->foto)
            <div class="row mb-3">
                <div class="col-sm-4 text-muted">Foto Pendukung</div>
                <div class="col-sm-8">
                    <a href="{{ asset('storage/' . $ticket->foto) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat Foto</a>
                </div>
            </div>
            @endif
            <hr>
            <div class="row mb-3">
                <div class="col-sm-4 text-muted">Teknisi Penanganan</div>
                <div class="col-sm-8">{{ $ticket->user ? $ticket->user->name : 'Belum ditentukan' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4 text-muted">Note Perbaikan</div>
                <div class="col-sm-8">{{ $ticket->note_perbaikan ?? '-' }}</div>
            </div>
            @if($ticket->status == 'COMPLETE' && $ticket->waktu_selesai)
            <div class="row mb-3">
                <div class="col-sm-4 text-muted">Waktu Selesai</div>
                <div class="col-sm-8 text-success fw-bold">{{ $ticket->waktu_selesai->format('d M Y H:i') }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
