<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // 1. Halaman Utama Publik (Daftar Tiket)
    public function publicIndex()
    {
        // Ambil semua tiket, urutkan dari yang terbaru
        $tickets = Ticket::latest()->paginate(15);
        
        // Cek apakah ada tiket yang baru saja dibuat user ini (dari session)
        $lastCreatedId = session('last_created_ticket_id');
        
        return view('tickets.public-index', compact('tickets', 'lastCreatedId'));
    }

    // 2. Form Buat Tiket
    public function create()
    {
        return view('tickets.create-public');
    }

    // 3. Simpan Tiket
    public function store(Request $request)
    {
        $request->validate([
            'reporter_name' => 'required|string|max:255',
            'reporter_email' => 'required|email',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        // Generate Kode Unik
        $dateCode = date('ymd');
        $randomCode = strtoupper(substr(md5(uniqid()), 0, 4));
        $trackingCode = 'TKT-' . $dateCode . '-' . $randomCode;

        $ticket = Ticket::create([
            'user_id' => null,
            'reporter_name' => $request->reporter_name,
            'reporter_email' => $request->reporter_email,
            'tracking_code' => $trackingCode,
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'open',
        ]);

        // SIMPAN ID TIKET KE SESSION AGAR BISA DI-HIGHLIGHT
        session(['last_created_ticket_id' => $ticket->id]);

        // Redirect kembali ke halaman utama dengan pesan sukses
        return redirect()->route('tickets.public.index')
                         ->with('success', 'Laporan berhasil dibuat! Kode Anda: ' . $trackingCode . ' (Lihat di bawah)');
    }

    // 4. Detail Tiket (Gabungan Public View & Admin Panel)
    public function show(Ticket $ticket)
    {
        return view('tickets.public-show', compact('ticket'));
    }

    // 5. Update Status (Khusus Admin)
    public function updateStatus(Request $request, Ticket $ticket)
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'status' => 'required|in:open,in_progress,resolved,closed',
        'assigned_to' => 'nullable|exists:users,id',
        'technician_note' => 'nullable|string|max:1000',
    ]);

    $data = $request->only(['status', 'assigned_to', 'technician_note']);

    // Logika Auto End Date
    $newStatus = $request->status;
    
    if (in_array($newStatus, ['resolved', 'closed'])) {
        // Jika status jadi selesai, isi waktu sekarang sebagai end date (jika belum ada)
        if (!$ticket->resolved_at) {
            $data['resolved_at'] = now();
        }
    } else {
        // Jika status dikembalikan ke open/in_progress, kosongkan end date
        $data['resolved_at'] = null;
    }

    $ticket->update($data);

    return back()->with('success', 'Status dan catatan berhasil diperbarui.');
    }
}