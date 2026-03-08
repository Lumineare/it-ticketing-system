<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Kolom pada database khusus model Auth yang dapat diisi bebas menggunakan parameter array.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Termasuk peran: admin / teknisi
    ];

    /**
     * Membangun relasi (HasMany) terhadap Model tiket.
     * Mengartikan bahwa satu User (teknisi) dapat memiliki "BANYAK" tiket yang sedang mereka kerjakan.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'teknisi', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
