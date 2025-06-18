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

    public static function canCreate(): bool
    {
        return false; // Admin dan employee tidak bisa membuat peminjaman baru
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('textBook.gambar')
                    ->label('Gambar')
                    ->circular()
                    ->size(50)
                    ->defaultImageUrl(fn () => asset('images/default-book.svg')),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Peminjam')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('textBook.judul')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('textBook.kode_buku')
                    ->label('Kode Buku')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mata_pelajaran')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guru_pengampu')
                    ->label('Guru Pengampu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kelas_keperluan')
                    ->label('Kelas/Keperluan'),
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
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'active',
                        'info' => 'return_pending',
                        'primary' => 'returned',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu Persetujuan',
                        'active' => 'Dipinjam',
                        'return_pending' => 'Menunggu Validasi Pengembalian',
                        'returned' => 'Dikembalikan',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu Persetujuan',
                        'active' => 'Dipinjam',
                        'return_pending' => 'Menunggu Validasi Pengembalian',
                        'returned' => 'Dikembalikan',
                        'rejected' => 'Ditolak',
                    ]),
                Tables\Filters\SelectFilter::make('textBook')
                    ->relationship('textBook', 'judul')
                    ->label('Buku')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (TextBookLoan $record): bool => $record->status === 'pending')
                    ->action(function (TextBookLoan $record): void {
                        $record->update(['status' => 'active']);

                        Notification::make()
                            ->title('Peminjaman berhasil disetujui')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (TextBookLoan $record): bool => $record->status === 'pending')
                    ->action(function (TextBookLoan $record): void {
                        $record->update(['status' => 'rejected']);

                        Notification::make()
                            ->title('Peminjaman berhasil ditolak')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('validate_return')
                    ->label('Validasi Pengembalian')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (TextBookLoan $record): bool => $record->status === 'return_pending')
                    ->action(function (TextBookLoan $record): void {
                        $record->update(['status' => 'returned']);

                        Notification::make()
                            ->title('Pengembalian buku berhasil divalidasi')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject_return')
                    ->label('Tolak Pengembalian')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (TextBookLoan $record): bool => $record->status === 'return_pending')
                    ->action(function (TextBookLoan $record): void {
                        $record->update(['status' => 'active']);

                        Notification::make()
                            ->title('Pengembalian buku ditolak, status dikembalikan ke dipinjam')
                            ->warning()
                            ->send();
                    }),
                Tables\Actions\ViewAction::make()
                    ->label('Lihat Detail'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user.name')
                    ->label('Nama Peminjam')
                    ->disabled(),
                Forms\Components\TextInput::make('textBook.judul')
                    ->label('Judul Buku')
                    ->disabled(),
                Forms\Components\TextInput::make('mata_pelajaran')
                    ->label('Mata Pelajaran')
                    ->disabled(),
                Forms\Components\TextInput::make('guru_pengampu')
                    ->label('Guru Pengampu')
                    ->disabled(),
                Forms\Components\TextInput::make('kelas_keperluan')
                    ->label('Kelas/Keperluan')
                    ->disabled(),
                Forms\Components\TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->disabled(),
                Forms\Components\DatePicker::make('loan_date')
                    ->label('Tanggal Pinjam')
                    ->disabled(),
                Forms\Components\DatePicker::make('return_date')
                    ->label('Tanggal Kembali')
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu Persetujuan',
                        'active' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                        'rejected' => 'Ditolak',
                    ])
                    ->disabled(),
                Forms\Components\Textarea::make('notes')
                    ->label('Catatan')
                    ->disabled(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTextBookLoans::route('/'),
            'view' => Pages\ViewTextBookLoan::route('/{record}'),
        ];
    }

}