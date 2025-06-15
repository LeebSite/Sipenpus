<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TextBookLoanResource\Pages;
use App\Models\TextBook;
use App\Models\TextBookLoan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class TextBookLoanResource extends Resource
{
    protected static ?string $model = TextBookLoan::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Peminjaman Buku Cetak';
    protected static ?string $navigationGroup = 'Manajemen Transaksi';
    protected static ?int $navigationSort = 4;

    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin' || auth()->user()->role === 'employee';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTextBookLoans::route('/'),
            'create' => Pages\CreateTextBookLoan::route('/create'),
            'edit' => Pages\EditTextBookLoan::route('/{record}/edit'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => auth()->id()),
                
                Forms\Components\Select::make('text_book_id')
                    ->relationship('textBook', 'judul')
                    ->required()
                    ->label('Buku Cetak')
                    ->searchable()
                    ->preload(),
                
                Forms\Components\TextInput::make('mata_pelajaran')
                    ->required()
                    ->label('Mata Pelajaran')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('guru_pengampu')
                    ->required()
                    ->label('Guru Pengampu')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('kelas_keperluan')
                    ->required()
                    ->label('Kelas/Keperluan')
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->label('Jumlah'),
                
                Forms\Components\DatePicker::make('loan_date')
                    ->required()
                    ->label('Tanggal Pinjam')
                    ->default(now()),
                
                Forms\Components\DatePicker::make('return_date')
                    ->required()
                    ->label('Tanggal Kembali')
                    ->default(now()->addDays(7)),
                
                Forms\Components\Hidden::make('status')
                    ->default('pending'),
                
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan')
                    ->maxLength(65535),
            ]);
    }
}

