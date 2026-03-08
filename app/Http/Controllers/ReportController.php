<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Menampilkan antarmuka Halaman Laporan.
     */
    public function index()
    {
        // Melemparkan data Teknisi dari database agar pilihan form "Filter Teknisi" berfungsi
        $technicians = \App\Models\User::where('role', 'teknisi')->get();
        return view('admin.reports.index', compact('technicians'));
    }

    /**
     * Merender data HTML (View report_pdf.blade.php) kepada DOMPDF engine, kemudian
     * menjadikan file PDF interaktif dan mengirim hasil instan pada browser client.
     */
    public function exportPdf(Request $request)
    {
        $query = \App\Models\Ticket::with('user')->latest();
        
        // Logika penyortiran apabila ada filter saat di export (status / teknisi penanggung jawab)
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('teknisi')) $query->where('teknisi', $request->teknisi);

        $tickets = $query->get();

        // Menyisipkan collection tiket ke dom pdf facade
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.report_pdf', compact('tickets'));
        // Mengunduh pdf dengan nama "laporan_tiket_{TahunBulanTanggal}.pdf"
        return $pdf->download('laporan_tiket_'.date('YmdHis').'.pdf');
    }

    /**
     * Membangkitkan stream fputcsv (raw output stream file) format .csv
     * Kompatibel penuh dan di parse otomatis di Microsoft EXCEL dalam struktur tabel.
     */
    public function exportExcel(Request $request)
    {
        $query = \App\Models\Ticket::with('user')->latest();
        
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('teknisi')) $query->where('teknisi', $request->teknisi);

        $tickets = $query->get();

        // Nama file Excel yang akan dihasilkan
        $filename = "laporan_tiket_" . date('YmdHis') . ".csv";
        
        // HTTP Headers untuk memberi tahu browser client merespon format CSV/unduhan (forced download)
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Menyusun List baris dari Kolom CSV tersebut
        $columns = ['ID Tiket', 'Tgl Laporan', 'Pelapor', 'Unit', 'Kendala', 'Prioritas', 'Teknisi', 'Status', 'Tgl Selesai'];

        $callback = function() use($tickets, $columns) {
            // Membuka memori server
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Baris kesatu menjadi Header string Column

            // Memasukkan values database satu per satu menggunakan looping iteratif
            foreach ($tickets as $t) {
                fputcsv($file, [
                    $t->ticket_id,
                    $t->waktu_laporan->format('Y-m-d H:i:s'),
                    $t->nama_pelapor,
                    $t->unit,
                    $t->deskripsi_kerusakan,
                    $t->prioritas,
                    $t->user ? $t->user->name : '', 
                    $t->status,
                    $t->waktu_selesai ? $t->waktu_selesai->format('Y-m-d H:i:s') : ''
                ]);
            }
            // Menutup proses memori dan melemparnya
            fclose($file);
        };

        // Melakukan pengirimen response stream pada browser
        return response()->stream($callback, 200, $headers);
    }
}
