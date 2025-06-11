<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TextBookLoanResource\Pages;
use App\Models\TextBook;
use App\Models\TextBookLoan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TextBookLoanResource extends Resource
{
    protected static ?string $model = TextBookLoan::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Peminjaman Buku Cetak';
    protected static ?string $navigationGroup = 'Perpustakaan';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('Peminjam')
                    ->searchable(),
                Forms\Components\Select::make('text_book_id')
                    ->relationship('textBook', 'judul')
                    ->required()
                    ->label('Buku Cetak')
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $textBook = TextBook::find($state);
                            if ($textBook) {
                                $set('mata_pelajaran', $textBook->mata_pelajaran);
                            }
                        }
                    }),
                Forms\Components\TextInput::make('mata_pelajaran')
                    ->required()
                    ->label('Mata Pelajaran')
                    ->maxLength(100),
                Forms\Components\TextInput::make('guru_pengampu')
                    ->required()
                    ->label('Guru Pengampu')
                    ->maxLength(100),
                Forms\Components\TextInput::make('kelas_keperluan')
                    ->required()
                    ->label('Kelas / Keperluan')
                    ->maxLength(100),
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->label('Jumlah')
                    ->numeric()
                    ->minValue(1)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        if ($state && $get('text_book_id')) {
                            $textBook = TextBook::find($get('text_book_id'));
                            if ($textBook && $state > $textBook->stok) {
                                $set('jumlah', $textBook->stok);
                            }
                        }
                    }),
                Forms\Components\DatePicker::make('loan_date')
                    ->required()
                    ->label('Tanggal Pinjam')
                    ->default(now()),
                Forms\Components\DatePicker::make('return_date')
                    ->required()
                    ->label('Tanggal Kembali')
                    ->default(now()),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Menunggu Persetujuan',
                        'active' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                        'rejected' => 'Ditolak',
                    ])
                    ->required()
                    ->default('pending'),
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Peminjam')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('textBook.judul')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mata_pelajaran')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guru_pengampu')
                    ->label('Guru Pengampu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kelas_keperluan')
                    ->label('Kelas / Keperluan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable(),
                Tables\Columns\TextColumn::make('loan_date')
                    ->label('Tanggal Pinjam')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('return_date')
                    ->label('Tanggal Kembali')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'active' => 'info',
                        'returned' => 'success',
                        'rejected' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu Persetujuan',
                        'active' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (TextBookLoan $record) => $record->status === 'pending')
                    ->action(function (TextBookLoan $record) {
                        $record->status = 'active';
                        $record->save();
                        
                        // Kurangi stok
                        $textBook = TextBook::find($record->text_book_id);
                        if ($textBook) {
                            $textBook->stok -= $record->jumlah;
                            $textBook->save();
                        }
                    }),
                Tables\Actions\Action::make('return')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('info')
                    ->visible(fn (TextBookLoan $record) => $record->status === 'active')
                    ->action(function (TextBookLoan $record) {
                        $record->status = 'returned';
                        $record->save();
                        
                        // Kembalikan stok
                        $textBook = TextBook::find($record->text_book_id);
                        if ($textBook) {
                            $textBook->stok += $record->jumlah;
                            $textBook->save();
                        }
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (TextBookLoan $record) => $record->status === 'pending')
                    ->action(function (TextBookLoan $record) {
                        $record->status = 'rejected';
                        $record->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTextBookLoans::route('/'),
            'create' => Pages\CreateTextBookLoan::route('/create'),
            'edit' => Pages\EditTextBookLoan::route('/{record}/edit'),
        ];
    }
    
    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin' || auth()->user()->role === 'employee';
    }
}