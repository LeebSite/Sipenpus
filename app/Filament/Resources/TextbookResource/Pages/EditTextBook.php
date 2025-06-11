<?php

namespace App\Filament\Resources\TextBookResource\Pages;

use App\Filament\Resources\TextBookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTextBook extends EditRecord
{
    protected static string $resource = TextBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Buku cetak pelajaran berhasil diperbarui';
    }
}