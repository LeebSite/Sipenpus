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
    protected static ?string $title = 'Detail Buku';
    protected static string $view = 'filament.pages.book-detail';
    
    public Book $book;
    public $hasPendingLoan = false;
    public bool $showCancelModal = false;
    protected ?Loan $pendingLoan = null;
    
    public function mount($id): void
    {
        if (Auth::user()->role !== 'member') {
            redirect()->to(Dashboard::getUrl());
        }
        
        $this->book = Book::findOrFail($id);
        
        // Get the pending loan first
        $this->pendingLoan = Loan::where('user_id', auth()->id())
            ->where('book_id', $this->book->id)
            ->whereIn('status', ['pending', 'active'])
            ->first();
            
        // Then set hasPendingLoan based on pendingLoan
        $this->hasPendingLoan = !is_null($this->pendingLoan);
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
        
        // Cek apakah user sudah memiliki permintaan peminjaman yang pending
        if ($this->hasPendingLoan) {
            Notification::make()
                ->title('Anda sudah mengajukan peminjaman untuk buku ini')
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
        
        // Update status permintaan peminjaman
        $this->hasPendingLoan = true;
        
        Notification::make()
            ->title('Permintaan peminjaman berhasil dibuat')
            ->success()
            ->send();
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
        public function toggleModal(): void
    {
        $this->showCancelModal = !$this->showCancelModal;
    }

    public function cancelLoan(): void
    {
        // Find the loan again in case it changed
        $this->pendingLoan = Loan::where('user_id', auth()->id())
            ->where('book_id', $this->book->id)
            ->where('status', 'pending')
            ->first();

        if (!$this->pendingLoan) {
            Notification::make()
                ->title('Tidak ada peminjaman yang dapat dibatalkan')
                ->danger()
                ->send();
            return;
        }

        $this->pendingLoan->delete();
        $this->pendingLoan = null;
        $this->hasPendingLoan = false;
        $this->showCancelModal = false;

        Notification::make()
            ->title('Permintaan peminjaman berhasil dibatalkan')
            ->success()
            ->send();
    }
}