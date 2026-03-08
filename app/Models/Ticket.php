<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * Kolom pada database yang diperbolehkan diisi secara Mass Assignment (seperti Ticket::create()).
     * Mencegah vulnerability Mass-Assignment pada input hacker.
     */
    protected $fillable = [
        'ticket_id',
        'nama_pelapor',
        'unit',
        'deskripsi_kerusakan',
        'foto',
        'jenis_trouble',
        'prioritas',
        'teknisi',
        'status',
        'note_perbaikan',
        'tindakan_lanjutan',
        'waktu_laporan',
        'waktu_selesai'
    ];

    /**
     * Memaksakan tipe data "cast" otomatis saat penarikan database oleh Model
     * Mengatur agar kolom waktu menjadi objek instance Carbon PHP saat digunakan
     */
    protected $casts = [
        'waktu_laporan' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    /**
     * Definisi relasi ORM (Object Relational Mapping).
     * Satu tiket ini "Milik (BelongsTo)" pada satu User (khususnya teknisi).
     * Foreign Key di database adalah "teknisi", merujuk pada "id" di model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'teknisi', 'id');
    }

    /**
     * Query Local Scope untuk memfilter "Tiket Aktif".
     * Tiket Aktif = Tiket yang BELUM COMPLETE, 
     * ATAU sudah COMPLETE namun diselesaikan pada hari ini (reset pukul 00:00:00).
     */
    public function scopeActiveTickets($query)
    {
        return $query->where(function ($q) {
            // Selalu tampilkan yang masih OPEN atau PROGRESS
            $q->where('status', '!=', 'COMPLETE')
              // ATAU tampilkan yang sudah COMPLETE tapi hanya jika dilaporkan hari ini
              // (Jika dilaporkan kemarin tapi baru selesai hari ini, akan langsung hilang)
              ->orWhere(function ($q2) {
                  $q2->where('status', 'COMPLETE')
                     ->whereDate('waktu_laporan', \Carbon\Carbon::today());
              });
        });
    }
}
