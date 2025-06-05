<?php

namespace App\Filament\Pages;

use App\Models\Book;
use App\Models\Loan;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class BookDetail extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $title = 'Book Detail';
    protected static string $view = 'filament.pages.book-detail';
    
    public Book $book;
    
    public function mount($id): void
    {
        if (Auth::user()->role !== 'member') {
            redirect()->to(Dashboard::getUrl());
        }
        
        $this->book = Book::findOrFail($id);
    }
    
    public function requestLoan()
    {
        // Cek apakah buku tersedia
        if ($this->book->status !== 'available') {
            Notification::make()
                ->title('Buku tidak tersedia')
                ->danger()
                ->send();
                
            return;
        }
        
        // Cek apakah user sudah meminjam buku ini
        $existingLoan = Loan::where('user_id', auth()->id())
            ->where('book_id', $this->book->id)
            ->where('status', 'active')
            ->first();
            
        if ($existingLoan) {
            Notification::make()
                ->title('Anda sudah meminjam buku ini')
                ->danger()
                ->send();
                
            return;
        }
        
        // Buat permintaan peminjaman
        Loan::create([
            'user_id' => auth()->id(),
            'book_id' => $this->book->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'pending', // pending, active, returned, rejected
        ]);
        
        Notification::make()
            ->title('Permintaan peminjaman berhasil dibuat')
            ->success()
            ->send();
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}