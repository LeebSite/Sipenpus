<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'kode_buku',
        'isbn',
        'judul',
        'penulis',
        'penerbit',
        'tanggal_terbit',
        'jumlah_halaman',
        'kategori',
        'deskripsi',
        'status',
    ];

        // Relasi dengan peminjaman buku
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    // Accessor untuk mengecek ketersediaan buku
    public function getIsAvailableAttribute(): bool 
    {
        return $this->quantity > 0 && $this->status === 'available';
    }
}
