<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use App\Models\Book;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLoan extends CreateRecord
{
    protected static string $resource = LoanResource::class;
    
    protected function handleRecordCreation(array $data): Model
    {
        // Update book status to unavailable if loan is active
        if ($data['status'] === 'active') {
            $book = Book::find($data['book_id']);
            $book->status = 'unavailable';
            $book->save();
        }
        
        return parent::handleRecordCreation($data);
    }
}