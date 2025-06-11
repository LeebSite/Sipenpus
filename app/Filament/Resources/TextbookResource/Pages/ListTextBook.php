<?php

namespace App\Filament\Resources\TextBookResource\Pages;

use App\Filament\Resources\TextBookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTextBook extends ListRecords
{
    protected static string $resource = TextBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Buku Cetak'),
        ];
    }
}
