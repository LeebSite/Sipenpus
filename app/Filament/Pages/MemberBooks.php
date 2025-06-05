<?php

namespace App\Filament\Pages;

use App\Models\Book;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MemberBooks extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Books';
    protected static ?string $title = 'Browse Books';
    protected static ?string $navigationGroup = 'Library';
    
    protected static string $view = 'filament.pages.member-books';
    
    public $search = '';
    public $kategori = '';
    
    public function mount(): void
    {
        if (Auth::user()->role !== 'member') {
            redirect()->to(Dashboard::getUrl());
        }
    }
    
    public function getViewData(): array
    {
        $query = Book::query();
        
        // Filter berdasarkan status
        $query->where('status', 'available');
        
        // Filter berdasarkan pencarian
        if ($this->search) {
            $query->where(function($q) {
                $q->where('judul', 'like', "%{$this->search}%")
                  ->orWhere('penulis', 'like', "%{$this->search}%")
                  ->orWhere('isbn', 'like', "%{$this->search}%");
            });
        }
        
        // Filter berdasarkan kategori
        if ($this->kategori) {
            $query->where('kategori', $this->kategori);
        }
        
        return [
            'books' => $query->paginate(12),
            'categories' => [
                'novel' => 'Novel',
                'fiksi' => 'Fiksi',
                'filsafat' => 'Filsafat',
                'komik' => 'Komik',
                'ilmiah' => 'Ilmiah',
            ]
        ];
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->role === 'member';
    }
}
