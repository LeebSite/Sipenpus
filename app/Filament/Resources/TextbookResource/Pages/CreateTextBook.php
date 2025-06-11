<?php

namespace App\Filament\Resources\TextBookResource\Pages;

use App\Filament\Resources\TextBookResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTextBook extends CreateRecord
{
    protected static string $resource = TextBookResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Buku cetak pelajaran berhasil ditambahkan';
    }
}
