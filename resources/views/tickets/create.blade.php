@extends('layouts.app')

@section('content')
<div class="page-header px-2 border-bottom-0 pb-0">
    <div class="text-start">
        <h2 class="fw-bold text-dark mb-2">Form Pembuatan Tiket</h2>
        <p class="text-secondary">Silakan lengkapi detail kendala yang dialami di bawah ini.</p>
    </div>
</div>

<hr class="my-4 opacity-25">

<div class="card-custom mb-5">
    <div class="card-body p-4 p-md-5">
        @if ($errors->any())
            <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ticket.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold text-secondary">Nama Pelapor <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg bg-light" name="nama_pelapor" value="{{ old('nama_pelapor') }}" required>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-semibold text-secondary">Asal Unit / Departemen <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg bg-light" name="unit" value="{{ old('unit') }}" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary">Deskripsi Kendala Secara Singkat <span class="text-danger">*</span></label>
                <textarea class="form-control form-control-lg bg-light" name="deskripsi_kerusakan" rows="5" placeholder="Contoh: Printer di ruang HRD tidak bisa men-print warna hitam..." required>{{ old('deskripsi_kerusakan') }}</textarea>
            </div>
            
            <div class="mb-5">
                <label class="form-label fw-semibold text-secondary">Upload Bukti Foto (Opsional)</label>
                <input type="file" class="form-control form-control-lg bg-light" name="foto" accept="image/*">
                <div class="form-text">Maksimal ukuran file: 2MB. Hanya format gambar (JPG, PNG).</div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                <a href="/" class="btn btn-light text-secondary fw-medium px-4">Batal</a>
                <button type="submit" class="btn btn-primary btn-lg shadow-sm px-5 rounded-pill">Kirim Laporan</button>
            </div>
        </form>
    </div>
</div>
@endsection
