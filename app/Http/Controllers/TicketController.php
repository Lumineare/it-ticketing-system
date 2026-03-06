<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // 1. Halaman Utama Publik (Daftar Tiket)
    public function publicIndex()
    {
        // Ambil semua tiket dengan relasi unit agar bisa ditampilkan namanya
        $tickets = Ticket::with('unit')->latest()->paginate(15);
        
        // Cek apakah ada tiket yang baru saja dibuat user ini (dari session)
        $lastCreatedId = session('last_created_ticket_id');
        
        return view('tickets.public-index', compact('tickets', 'lastCreatedId'));
    }

    // 2. Form Buat Tiket
    public function create()
    {
        // Ambil semua unit untuk dropdown
        $units = Unit::orderBy('name')->get();
        return view('tickets.create-public', compact('units'));
    }

    // 3. Simpan Tiket (SUDAH DIPERBAIKI URUTANNYA)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'reporter_name' => 'required|string|max:255',
            'unit_id'       => 'required|exists:units,id', 
            'subject'       => 'required|string|max:255',
            'description'   => 'required|string',
            'priority'      => 'required|in:low,medium,high',
        ]);

        // --- LOGIKA GENERATE KODE UNIK BARU ---
        // 1. Ambil tanggal hari ini dalam format YYYYMMDD
        $dateCode = date('Ymd'); 
        
        // 2. Buat string acak 5 karakter (Huruf Besar + Angka)
        $randomString = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5));
        
        // 3. Gabungkan menjadi format final: TKT-YYYYMMDD-XXXXX
        $trackingCode = 'TKT-' . $dateCode . '-' . $randomString;

        // 4. Cek apakah kode sudah pernah dipakai (untuk antisipasi tabrakan sangat jarang)
        while (Ticket::where('tracking_code', $trackingCode)->exists()) {
            $randomString = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5));
            $trackingCode = 'TKT-' . $dateCode . '-' . $randomString;
        }
        // -------------------------------------

        // 5. BUAT TIKET DULUAN (Ini langkah yang sebelumnya salah urutan)
        $ticket = Ticket::create([
            'user_id'         => null,
            'reporter_name'   => $request->reporter_name,
            'unit_id'         => $request->unit_id, 
            'tracking_code'   => $trackingCode,
            'subject'         => 'Laporan Masalah Umum',
            'description'     => $request->description,
            'priority'        => $request->priority,
            'status'          => 'open',
        ]);

        // 6. BARU SIMPAN ID KE SESSION SETELAH TIKET TERBENTUK
        session(['last_created_ticket_id' => $ticket->id]);

        // Redirect kembali ke halaman utama dengan pesan sukses
        return redirect()->route('tickets.public.index')
                         ->with('success', 'Laporan berhasil dibuat! Kode Anda: <strong>' . $trackingCode . '</strong> (Simpan kode ini)');
    }

    // 4. Detail Tiket (Gabungan Public View & Admin Panel)
    public function show(Ticket $ticket)
    {
        // Siapkan data untuk Admin Panel
        // 1. Daftar Unit (untuk referensi)
        $units = Unit::all();
        
        // 2. Daftar Teknisi (User dengan role 'admin' atau 'teknisi')
        // Kita ambil semua user yang bisa menjadi pelaksana
        $technicians = User::whereIn('role', ['admin', 'teknisi'])->orderBy('name')->get();

        return view('tickets.public-show', compact('ticket', 'units', 'technicians'));
    }

    // 5. Update Status (Khusus Admin)
    public function updateStatus(Request $request, Ticket $ticket)
    {
        // Keamanan: Hanya admin yang boleh akses
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status'          => 'required|in:open,in_progress,resolved,closed',
            'assigned_to'     => 'nullable|exists:users,id',
            'technician_note' => 'nullable|string|max:1000',
        ]);

        $newStatus = $request->status;
        $currentStatus = $ticket->status;

        // --- LOGIKA KEAMANAN BARU: Cegah Edit Jika Sudah Closed ---
        if ($currentStatus === 'closed') {
            return back()->with('error', 'Maaf, laporan ini sudah ditutup (Closed) dan tidak dapat diubah.');
        }

        $data = $request->only(['status', 'assigned_to', 'technician_note']);

        // Logika Auto End Date
        if (in_array($newStatus, ['resolved', 'closed'])) {
            // Jika status jadi selesai/ditutup, isi waktu sekarang sebagai end date (jika belum ada)
            if (!$ticket->resolved_at) {
                $data['resolved_at'] = now();
            }
        } else {
            // Jika status dikembalikan ke open/in_progress, kosongkan end date (karena sedang dikerjakan lagi)
            $data['resolved_at'] = null;
        }

        $ticket->update($data);

        return back()->with('success', 'Status dan catatan berhasil diperbarui.');
    }
}