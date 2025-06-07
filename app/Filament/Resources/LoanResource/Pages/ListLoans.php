<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListLoans extends ListRecords
{
    protected static string $resource = LoanResource::class;

    protected function getHeaderActions(): array
    {
        // Only admin and employee can create loans directly
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'employee') {
            return [
                Actions\CreateAction::make()->label('Tambah Peminjaman'),
            ];
        }
        
        return [];
    }
}
