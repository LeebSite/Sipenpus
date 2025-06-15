<?php

namespace App\Filament\Resources\TextBookLoanResource\Pages;

use App\Filament\Resources\TextBookLoanResource;
use App\Models\TextBookLoan;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewTextBookLoan extends ViewRecord
{
    protected static string $resource = TextBookLoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->label('Setujui Peminjaman')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn (): bool => $this->record->status === 'pending')
                ->action(function (): void {
                    $this->record->update(['status' => 'active']);
                    
                    Notification::make()
                        ->title('Peminjaman berhasil disetujui')
                        ->success()
                        ->send();
                        
                    $this->redirect($this->getResource()::getUrl('index'));
                }),
            Actions\Action::make('reject')
                ->label('Tolak Peminjaman')
                ->icon('heroicon-o-x-mark')
                ->color('danger')
                ->visible(fn (): bool => $this->record->status === 'pending')
                ->action(function (): void {
                    $this->record->update(['status' => 'rejected']);
                    
                    Notification::make()
                        ->title('Peminjaman berhasil ditolak')
                        ->success()
                        ->send();
                        
                    $this->redirect($this->getResource()::getUrl('index'));
                }),
            Actions\Action::make('return')
                ->label('Kembalikan Buku')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('primary')
                ->visible(fn (): bool => $this->record->status === 'active')
                ->action(function (): void {
                    $this->record->update(['status' => 'returned']);
                    
                    Notification::make()
                        ->title('Buku berhasil dikembalikan')
                        ->success()
                        ->send();
                        
                    $this->redirect($this->getResource()::getUrl('index'));
                }),
            Actions\EditAction::make()
                ->label('Edit')
                ->visible(fn (): bool => false), // Disable edit untuk sementara
        ];
    }
    
    public function getTitle(): string 
    {
        return 'Detail Peminjaman Buku Cetak';
    }
}
