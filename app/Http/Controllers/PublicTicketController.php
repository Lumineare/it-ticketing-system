<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicTicketController extends Controller
{
    /**
     * Menampilkan halaman portal publik di halaman awal website (/).
     * Mengambil daftar tiket secara umum untuk dirender pada tabel antarmuka publik.
     */
    public function index()
    {
        // Menarik tiket-tiket beserta relasi ke usernya (teknisi yang menangani) 
        // secara eager-loading agar mempercepat proses query.
        // Memakai local scope activeTickets() untuk menyembunyikan tiket COMPLETE > 24 jam.
        $tickets = \App\Models\Ticket::with('user')->activeTickets()->latest()->paginate(10);
        return view('welcome', compact('tickets'));
    }

    /**
     * Mengarahkan user biasa/guest ke halaman Form Pengisian Laporan Tiket Baru.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Proses Menerima data masukan POST pembuatan tiket dari form publik dan menyimpannya ke database.
     */
    public function store(Request $request)
    {
        // Validasi struktur dan input agar tidak menyebabkan error di SQL.
        $validated = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'deskripsi_kerusakan' => 'required|string',
            'foto' => 'nullable|image|max:2048', // Ukuran foto maksimum 2MB (.jpg/.jpeg/.png).
        ]);

        // Apabila form mengandung file bertama var 'foto', masukkan file ke Storage Server di path 'tickets'.
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('tickets', 'public');
        }

        // --- Logika Pembuatan Random-Formatted Ticket ID (contoh: TCK-20231024-0001) ---
        $date = date('Ymd'); // Ambil YMD string saat ini
        // Cek ID tiket terakhir yang dibuat hari ini di database
        $lastTicket = \App\Models\Ticket::whereDate('created_at', \Carbon\Carbon::today())->latest('id')->first();
        // Jika tiket ada, hitung jumlah string ke-4 dari kanan dan plus (+) 1. Jika undefined, start 1.
        $sequence = $lastTicket ? ((int) substr($lastTicket->ticket_id, -4)) + 1 : 1;
        // Membentuk pattern Ticket ID.
        $ticketId = 'TCK-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Pasang property otomatis sebelum melempar command create.
        $validated['ticket_id'] = $ticketId;
        $validated['status'] = 'OPEN'; // Status default tiket baru
        
        // Memasukkan dan menyimpan semua data menjadi baris row baru pada database.
        $ticket = \App\Models\Ticket::create($validated);

        // Redirect pengguna ke halaman konfirmasi yang berisi detail tiket untuk dilacak kembali ke depannya.
        return redirect()->route('ticket.show', $ticketId)->with('success', 'Ticket berhasil dibuat!');
    }

    /**
     * Menampilkan Halaman Riwayat/Tinjauan Detail sebuah tiket menggunakan parameter ID tertentu
     */
    public function show($ticket_id)
    {
        // Mencari riwayat Tiket sesuai pencocokan kolom custom 'ticket_id'
        $ticket = \App\Models\Ticket::where('ticket_id', $ticket_id)->with('user')->firstOrFail();
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Menampilkan semua tiket yang sudah dirampungkan (Riwayat Publik)
     */
    public function completed()
    {
        // Tarik semua tiket dengan status COMPLETE terurut dari waktu_selesai terbaru ke terlama.
        $tickets = \App\Models\Ticket::with('user')->where('status', 'COMPLETE')->latest('waktu_selesai')->paginate(15);
        return view('tickets.completed', compact('tickets'));
    }
}
