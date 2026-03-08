<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    /**
     * Menampilkan daftar semua tiket untuk Admin dan Teknisi.
     * Fitur ini mencakup pencarian (search), filter status/prioritas/teknisi, dan pagination.
     */
    public function index(Request $request)
    {
        // Memulai query tiket beserta data user (teknisi) menggunakan Eager Loading
        // Hanya nampilkan tiket aktif (belum selesai, atau selesai < 24 jam)
        $query = \App\Models\Ticket::query()->with('user')->activeTickets();

        // Filter berdasarkan status tiket (OPEN, PROGRESS, COMPLETE)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tingkat prioritas (Low, Medium, High, Critical)
        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }
        
        // Filter berdasarkan teknisi yang ditugaskan
        if ($request->filled('teknisi')) {
            $query->where('teknisi', $request->teknisi);
        }
        
        // Pencarian teks pada ID tiket, Nama Pelapor, atau Unit / Departemen
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_id', 'like', "%{$search}%")
                  ->orWhere('nama_pelapor', 'like', "%{$search}%")
                  ->orWhere('unit', 'like', "%{$search}%");
            });
        }

        // Mengambil data tiket urut dari yang terbaru dengan pagination 15 item per halaman
        $tickets = $query->latest()->paginate(15)->withQueryString();
        
        // Mengambil daftar semua teknisi untuk ditampilkan di dropdown filter
        $technicians = \App\Models\User::where('role', 'teknisi')->get();

        return view('admin.tickets.index', compact('tickets', 'technicians'));
    }

    /**
     * Menampilkan halaman detail spesifik untuk satu tiket beserta form untuk update status.
     * ID pada parameter diambil dari URL rute.
     */
    public function show($id)
    {
        // Mencari tiket berdasarkan ID, akan menghasilkan error 404 jika ID tidak ditemukan
        $ticket = \App\Models\Ticket::with('user')->findOrFail($id);
        
        // Mengambil daftar teknisi untuk dropdown pada form "Penugasan"
        $technicians = \App\Models\User::where('role', 'teknisi')->get();
        return view('admin.tickets.show', compact('ticket', 'technicians'));
    }

    /**
     * Menyimpan perubahan data/status dari halaman detail tiket yang dikirim oleh Admin/Teknisi.
     */
    public function update(Request $request, $id)
    {
        // Mengambil data tiket berdasarkan ID
        $ticket = \App\Models\Ticket::findOrFail($id);

        // Validasi: Jika tiket sudah COMPLETE, tidak boleh ada perubahan apa pun untuk mencegah manipulasi data histori
        if ($ticket->status === 'COMPLETE') {
            return back()->withErrors(['status' => 'Tiket yang sudah selesai tidak dapat diubah lagi.'])->withInput();
        }

        // Validasi format dan isi dari input form sebelum disimpan ke database
        $validated = $request->validate([
            'jenis_trouble' => 'nullable|in:Hardware,Network,Komunikasi,Software',
            'prioritas' => 'nullable|in:Low,Medium,High,Critical',
            'teknisi' => 'nullable|exists:users,id',
            'status' => 'required|in:OPEN,PROGRESS,COMPLETE',
            'note_perbaikan' => 'nullable|string',
            'tindakan_lanjutan' => 'nullable|string',
        ]);

        // Hitungan logika urutan status tiket. 
        // PROGRESS adalah tiket yang sedang dikerjakan, tidak make sense jika dikembalikan ke antrian awal (OPEN)
        if ($ticket->status === 'PROGRESS' && $validated['status'] === 'OPEN') {
            return back()->withErrors(['status' => 'Tiket yang sedang dalam PROGRESS tidak dapat dikembalikan ke OPEN.'])->withInput();
        }

        // Jika status yang disubmit adalah COMPLETE dan sebelumnya belum COMPLETE,
        // maka otomatis catat waktu kompresi saat ini ke dalam 'waktu_selesai'
        if ($validated['status'] == 'COMPLETE' && $ticket->status != 'COMPLETE') {
            $validated['waktu_selesai'] = now();
        }

        // Simpan semua variabel yang telah di check/validasi ke database
        $ticket->update($validated);

        // Arahkan kembali pengguna ke list tiket dengan memunculkan alert sukses
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket berhasil diupdate!');
    }

    /**
     * Menampilkan daftar semua tiket historis yang telah selesai (Completed Tickets).
     * Berisi tiket-tiket yang sudah Complete lebih dari 24 jam.
     */
    public function completed(Request $request) 
    {
        $query = \App\Models\Ticket::with('user')->where('status', 'COMPLETE');

        // Fitur pencarian spesifik untuk menu Completed
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ticket_id', 'like', "%{$search}%")
                  ->orWhere('nama_pelapor', 'like', "%{$search}%")
                  ->orWhere('unit', 'like', "%{$search}%");
            });
        }

        $tickets = $query->latest('waktu_selesai')->paginate(15)->withQueryString();
        
        return view('admin.tickets.completed', compact('tickets'));
    }
}
