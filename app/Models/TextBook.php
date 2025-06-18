<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TextBook extends Model
{
    protected $fillable = [
        'judul',
        'kode_buku',
        'mata_pelajaran',
        'kelas',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'deskripsi',
        'gambar',
    ];

    // Relasi dengan peminjaman buku cetak
    public function textBookLoans(): HasMany
    {
        return $this->hasMany(TextBookLoan::class);
    }

    // Accessor untuk URL gambar
    public function getImageUrlAttribute(): string
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }

        return asset('images/default-book.svg');
    }

    // Accessor untuk mengecek ketersediaan stok
    public function getIsAvailableAttribute(): bool
    {
        return $this->stok > 0;
    }
}