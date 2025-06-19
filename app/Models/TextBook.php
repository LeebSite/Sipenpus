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
}