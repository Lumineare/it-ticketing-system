<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;

// --- ROUTE PUBLIK (TANPA LOGIN) ---

// 1. Halaman Utama: Daftar Tiket Publik (Bisa dilihat semua orang)
Route::get('/', [TicketController::class, 'publicIndex'])->name('tickets.public.index');

// 2. Form Buat Tiket & Simpan
Route::get('/buat-tiket', [TicketController::class, 'create'])->name('tickets.public.create');
Route::post('/buat-tiket', [TicketController::class, 'store'])->name('tickets.public.store');

// 3. Halaman Detail Tiket (Publik hanya baca, Admin bisa edit jika login)
Route::get('/tiket/{ticket}', [TicketController::class, 'show'])->name('tickets.public.show');

// --- ROUTE KHUSUS ADMIN (WAJIB LOGIN) ---

// Login Admin
Route::get('/admin/login', function () {
    return view('auth.login-admin');
})->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return back()->withErrors(['email' => 'Akses ditolak. Hanya admin IT yang boleh masuk.']);
        }
        $request->session()->regenerate();
        // Setelah login, redirect ke halaman utama (yang sama, tapi sekarang ada panel admin)
        return redirect()->route('tickets.public.index');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('admin.logout');

// Route Khusus Admin untuk Update Status (Hanya bisa diakses jika sudah login & validasi di controller)
Route::middleware(['auth'])->group(function () {
    Route::patch('/admin/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('admin.tickets.updateStatus');
    
    // Dashboard khusus admin (opsional, bisa diarahkan ke halaman utama juga)
    Route::get('/admin/dashboard', [TicketController::class, 'publicIndex'])->name('admin.dashboard');
});