<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Mempersiapkan seluruh ringkasan statistik dan grafikal yang tampil 
     * sebelum Blade me-render (membuat HTML) halaman dashboard utama Backend.
     */
    public function index()
    {
        // Kalkulasi angka-angka metrik tiket secara keseluruhan dan per kategori
        $totalTickets = \App\Models\Ticket::count();
        $openTickets = \App\Models\Ticket::where('status', 'OPEN')->count();
        $progressTickets = \App\Models\Ticket::where('status', 'PROGRESS')->count();
        $completeTickets = \App\Models\Ticket::where('status', 'COMPLETE')->count();

        // -------------------------------------------------------------
        // PEMBUATAN GRAFIK (CHART DATA)
        // Mengekstrak bulan pembuatan tiket menggunakan perintah SQL "MONTH()"
        // Disortir pada bulan di dalam tahun saat ini.
        // -------------------------------------------------------------
        $monthlyTickets = \App\Models\Ticket::selectRaw('MONTH(created_at) as month, count(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')->toArray();

        // Template basic array dengan Index dari bulan ke-1 (Jan) sampai 12 (Des).
        // Setiap bulannya di-initialize null atau bernilai 0
        $chartData = array_fill(1, 12, 0);
        
        // Replace bulan terkait dengan hasil penghitungan jika ada pembuatan tiket pada bulan tersebut.
        foreach ($monthlyTickets as $month => $count) {
            $chartData[$month] = $count;
        }

        // Tembak data variable ke view `admin.dashboard`
        return view('admin.dashboard', compact(
            'totalTickets', 'openTickets', 'progressTickets', 'completeTickets', 'chartData'
        ));
    }
}
