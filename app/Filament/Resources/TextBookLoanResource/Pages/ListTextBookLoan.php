<?php

namespace App\Filament\Resources\TextBookLoanResource\Pages;

use App\Filament\Resources\TextBookLoanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTextBookLoans extends ListRecords
{
    protected static string $resource = TextBookLoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Admin dan employee tidak bisa membuat peminjaman baru
            // Peminjaman hanya bisa dibuat oleh member melalui katalog
        ];
    }

    public function getTitle(): string
    {
        return 'Daftar Peminjaman Buku Cetak';
    }
}