<?php

namespace App\Filament\Resources\TextBookLoanResource\Pages;

use App\Filament\Resources\TextBookLoanResource;
use App\Models\TextBook;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class CreateTextBookLoan extends CreateRecord
{
    protected static string $resource = TextBookLoanResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Peminjaman buku cetak berhasil dibuat';
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Pastikan user_id selalu ada
        $data['user_id'] = $data['user_id'] ?? Auth::id();
        
        // Pastikan status selalu ada
        $data['status'] = $data['status'] ?? 'pending';
        
        return $data;
    }
    
    protected function handleRecordCreation(array $data): Model
    {
        // Validasi data wajib
        $requiredFields = ['user_id', 'text_book_id', 'mata_pelajaran', 'guru_pengampu', 
                          'kelas_keperluan', 'jumlah', 'loan_date', 'return_date'];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                // Tampilkan notifikasi error
                Notification::make()
                    ->title("Field $field wajib diisi")
                    ->danger()
                    ->send();
                
                // Throw exception untuk menghentikan proses
                throw new \Exception("Field $field wajib diisi");
            }
        }
        
        // Pastikan status selalu ada
        if (!isset($data['status'])) {
            $data['status'] = 'pending';
        }
        
        // Jika status peminjaman adalah active, kurangi stok buku
        if ($data['status'] === 'active') {
            $textBook = TextBook::find($data['text_book_id']);
            if ($textBook) {
                $textBook->stok -= $data['jumlah'];
                $textBook->save();
            }
        }
        
        return parent::handleRecordCreation($data);
    }
}

