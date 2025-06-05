<?php

namespace App\Filament\Pages;

use App\Models\Book;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class MemberBooks extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Books';
    protected static ?string $title = 'Browse Books';
    protected static ?string $navigationGroup = 'Library';
    
    protected static string $view = 'filament.pages.member-books';
    
    public function mount(): void
    {
        if (Auth::user()->role !== 'member') {
            redirect()->to(Dashboard::getUrl());
        }
    }
    
    public function getViewData(): array
    {
        return [
            'books' => Book::where('status', 'available')->paginate(12)
        ];
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->role === 'member';
    }
}