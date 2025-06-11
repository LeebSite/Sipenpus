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
            Actions\CreateAction::make()->label('Tambah Peminjaman'),
        ];
    }
}