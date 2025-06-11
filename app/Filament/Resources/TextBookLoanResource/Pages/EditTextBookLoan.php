<?php

namespace App\Filament\Resources\TextBookLoanResource\Pages;

use App\Filament\Resources\TextBookLoanResource;
use App\Models\TextBook;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTextBookLoan extends EditRecord
{
    protected static string $resource = TextBookLoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Hapus'),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Peminjaman buku cetak berhasil diperbarui';
    }
    
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $oldStatus = $record->status;
        $newStatus = $data['status'];
        $oldJumlah = $record->jumlah;
        $newJumlah = $data['jumlah'];
        
        $textBook = TextBook::find($record->text_book_id);
        
        // Jika status berubah, update stok buku
        if ($oldStatus !== $newStatus) {
            if ($oldStatus === 'pending' && $newStatus === 'active') {
                // Peminjaman disetujui, kurangi stok
                if ($textBook) {
                    $textBook->stok -= $newJumlah;
                    $textBook->save();
                }
            } elseif ($oldStatus === 'active' && $newStatus === 'returned') {
                // Buku dikembalikan, tambah stok
                if ($textBook) {
                    $textBook->stok += $oldJumlah;
                    $textBook->save();
                }
            } elseif ($oldStatus === 'pending' && $newStatus === 'rejected') {
                // Peminjaman ditolak, tidak perlu update stok
            } elseif ($oldStatus === 'active' && $newStatus === 'pending') {
                // Peminjaman dibatalkan, kembalikan stok
                if ($textBook) {
                    $textBook->stok += $oldJumlah;
                    $textBook->save();
                }
            }
        } 
        // Jika status tetap active tapi jumlah berubah
        elseif ($oldStatus === 'active' && $newStatus === 'active' && $oldJumlah !== $newJumlah) {
            if ($textBook) {
                // Kembalikan stok lama, lalu kurangi dengan jumlah baru
                $textBook->stok = $textBook->stok + $oldJumlah - $newJumlah;
                $textBook->save();
            }
        }
        
        return parent::handleRecordUpdate($record, $data);
    }
}
