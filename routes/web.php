<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// RUTE AREA PUBLIK (Tanpa Login)
// ==========================================
// 1. Halaman utama (Daftar laporan tiket masuk)
Route::get('/', [\App\Http\Controllers\PublicTicketController::class, 'index'])->name('welcome');

// 2. Form laporan tiket baru dan aksi submitnya
Route::get('/ticket/create', [\App\Http\Controllers\PublicTicketController::class, 'create'])->name('ticket.create');
Route::post('/ticket/store', [\App\Http\Controllers\PublicTicketController::class, 'store'])->name('ticket.store');

// 3. Tampilan spesifik sebuah riwayat tiket berdasarkan ID Laporan (TCK-XXXXX)
Route::get('/ticket/{ticket_id}', [\App\Http\Controllers\PublicTicketController::class, 'show'])->name('ticket.show');

// 4. Halaman histori seluruh laporan tiket publik yang sudah selesai
Route::get('/tickets-completed', [\App\Http\Controllers\PublicTicketController::class, 'completed'])->name('tickets.completed');


// ==========================================
// RUTE AUTHENTIKASI & LOGIN
// ==========================================
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


// ==========================================
// RUTE BACKEND / SISTEM ADMIN & TEKNISI 
// ==========================================
// Middleware akan mengecek: 1. Harus Login, 2. Role yg login harus admin atau teknisi
Route::middleware(['auth', 'role:admin,teknisi'])->group(function () {
    // Halaman Dashboard Beranda
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // ----------- Manajemen Semua Tiket -----------
    Route::get('/admin/tickets-completed', [\App\Http\Controllers\AdminTicketController::class, 'completed'])->name('admin.tickets.completed');
    Route::get('/admin/tickets', [\App\Http\Controllers\AdminTicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/admin/tickets/{id}', [\App\Http\Controllers\AdminTicketController::class, 'show'])->name('admin.tickets.show');
    Route::put('/admin/tickets/{id}', [\App\Http\Controllers\AdminTicketController::class, 'update'])->name('admin.tickets.update');

    // ----------- Fitur Cetak Laporan -------------
    Route::get('/admin/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/pdf', [\App\Http\Controllers\ReportController::class, 'exportPdf'])->name('admin.reports.pdf');
    Route::get('/admin/reports/excel', [\App\Http\Controllers\ReportController::class, 'exportExcel'])->name('admin.reports.excel');

    // ----------- Manajemen User (Menambah Teknisi) -----------
    // Catatan: Jika ingin ini KHUSUS untuk ADMIN saja, bisa pisah middleware 'role:admin'.
    // Tapi karena ini instruksi general, ada di group admin+teknisi. (Disembunyikan di sidebar utk teknisi).
    Route::get('/admin/users', [\App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [\App\Http\Controllers\AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users/store', [\App\Http\Controllers\AdminUserController::class, 'store'])->name('admin.users.store');
    Route::delete('/admin/users/{id}', [\App\Http\Controllers\AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});
