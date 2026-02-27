<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
protected $fillable = [
    'user_id', 
    'reporter_name', // Baru
    'reporter_email', // Baru
    'subject', 
    'description', 
    'priority', 
    'status', 
    'assigned_to',
    'technician_note', // Baru
    'resolved_at',     // Baru
    'unit_id',        // Baru
    ];

    // Agar tanggal otomatis dikonversi ke objek Carbon
    protected $casts = [
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
    ];
    
    /**
     * Relasi ke User (Pelapor)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke User (Teknisi yang ditugaskan)
     */
    public function assignedTechnician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Relasi ke Unit
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Relasi ke Komentar
     * CATATAN: Jika tabel 'comments' belum dibuat, kode ini akan error saat diakses.
     * Untuk sementara, kita bisa comment baris ini jika tabel comments belum ada.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}