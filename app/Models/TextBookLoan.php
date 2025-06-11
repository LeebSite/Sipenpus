<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TextBookLoan extends Model
{
    protected $fillable = [
        'user_id',
        'text_book_id',
        'mata_pelajaran',
        'guru_pengampu',
        'kelas_keperluan',
        'jumlah',
        'loan_date',
        'return_date',
        'status',
        'notes',
    ];
    
    protected $casts = [
        'loan_date' => 'date',
        'return_date' => 'date',
    ];

    // Relasi dengan user (peminjam)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan buku cetak
    public function textBook(): BelongsTo
    {
        return $this->belongsTo(TextBook::class);
    }
}