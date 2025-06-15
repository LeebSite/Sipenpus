<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoanResource\Pages;
use App\Models\Loan;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Peminjaman';
    protected static ?string $pluralModelLabel = 'Peminjaman';
    protected static ?string $modelLabel = 'Peminjaman';
    protected static ?string $navigationGroup = 'Manajemen Transaksi';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('Peminjam')
                    ->searchable(),
                Forms\Components\Select::make('book_id')
                    ->relationship('book', 'judul')
                    ->required()
                    ->label('Buku')
                    ->searchable(),
                Forms\Components\DatePicker::make('loan_date')
                    ->required()
                    ->label('Tanggal Pinjam')
                    ->default(now()),
                Forms\Components\DatePicker::make('due_date')
                    ->required()
                    ->label('Tanggal Jatuh Tempo')
                    ->default(now()->addDays(7)),
                Forms\Components\DatePicker::make('return_date')
                    ->label('Tanggal Kembali'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Menunggu Persetujuan',
                        'active' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                        'rejected' => 'Ditolak',
                        'overdue' => 'Terlambat',
                    ])
                    ->required()
                    ->label('Status')
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
                Tables\Columns\TextColumn::make('book.judul')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('book.kode_buku')
                    ->label('Kode Buku'),
                Tables\Columns\TextColumn::make('loan_date')
                    ->label('Tanggal Pinjam')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
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
                        'overdue' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu Persetujuan',
                        'active' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                        'rejected' => 'Ditolak',
                        'overdue' => 'Terlambat',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu Persetujuan',
                        'active' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                        'rejected' => 'Ditolak',
                        'overdue' => 'Terlambat',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Loan $record) => $record->status === 'pending' && (Auth::user()->role === 'admin' || Auth::user()->role === 'employee'))
                    ->action(function (Loan $record) {
                        $book = Book::find($record->book_id);
                        $book->status = 'unavailable';
                        $book->save();
                        
                        $record->status = 'active';
                        $record->save();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (Loan $record) => $record->status === 'pending' && (Auth::user()->role === 'admin' || Auth::user()->role === 'employee'))
                    ->action(function (Loan $record) {
                        $record->status = 'rejected';
                        $record->save();
                    }),
                Tables\Actions\Action::make('return')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->visible(fn (Loan $record) => $record->status === 'active' && (Auth::user()->role === 'admin' || Auth::user()->role === 'employee'))
                    ->action(function (Loan $record) {
                        $book = Book::find($record->book_id);
                        $book->status = 'available';
                        $book->save();
                        
                        $record->status = 'returned';
                        $record->return_date = now();
                        $record->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus'),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // Filter based on user role
        if (Auth::user()->role === 'member') {
            return $query->where('user_id', Auth::id());
        }
        
        return $query;
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin' || auth()->user()->role === 'employee';
    }
}


