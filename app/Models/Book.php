<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

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
        'gambar',
        'status',
    ];
    
    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    // Relasi dengan peminjaman buku
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    // Accessor untuk mengecek ketersediaan buku
    public function getIsAvailableAttribute(): bool 
    {
        return $this->status === 'available';
    }
}


