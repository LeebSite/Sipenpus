<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'notes',
    ];
    
    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    // Relasi dengan user (peminjam)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan buku
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Accessor untuk mengecek keterlambatan
    public function getIsOverdueAttribute(): bool 
    {
        if ($this->status !== 'active') {
            return false;
        }
        
        return Carbon::now()->greaterThan($this->due_date);
    }
}
