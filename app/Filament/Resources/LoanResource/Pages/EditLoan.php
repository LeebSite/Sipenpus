<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use App\Models\Book;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditLoan extends EditRecord
{
    protected static string $resource = LoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $oldStatus = $record->status;
        $newStatus = $data['status'];
        $book = Book::find($record->book_id);
        
        // Update book status based on loan status changes
        if ($oldStatus !== $newStatus) {
            if ($newStatus === 'active') {
                $book->status = 'unavailable';
                $book->save();
            } elseif ($newStatus === 'returned' || $newStatus === 'rejected') {
                $book->status = 'available';
                $book->save();
            }
        }
        
        return parent::handleRecordUpdate($record, $data);
    }
}