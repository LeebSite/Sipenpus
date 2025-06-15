<?php

namespace App\Filament\Pages;

use App\Models\TextBookLoan;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class MyTextBookLoans extends Page implements HasTable
{
    use InteractsWithTable;
    
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Peminjaman Buku Cetak Saya';
    protected static ?string $navigationGroup = 'Transaksi Saya';
    protected static ?int $navigationSort = 4;
    protected static string $view = 'filament.pages.my-text-book-loans';
    
    public function mount(): void
    {
        if (Auth::user()->role !== 'member') {
            redirect()->to(Dashboard::getUrl());
        }
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                TextBookLoan::query()
                    ->where('user_id', Auth::id())
                    ->latest()
            )
            ->columns([
                TextColumn::make('textBook.judul')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('mata_pelajaran')
                    ->label('Mata Pelajaran')
                    ->searchable(),
                TextColumn::make('guru_pengampu')
                    ->label('Guru Pengampu'),
                TextColumn::make('kelas_keperluan')
                    ->label('Kelas/Keperluan'),
                TextColumn::make('jumlah')
                    ->label('Jumlah'),
                TextColumn::make('loan_date')
                    ->label('Tanggal Pinjam')
                    ->date(),
                TextColumn::make('return_date')
                    ->label('Tanggal Kembali')
                    ->date(),
                BadgeColumn::make('status')
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
            ])
            ->filters([])
            ->actions([
                Action::make('cancel')
                    ->label('Batalkan')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (TextBookLoan $record): bool => $record->status === 'pending')
                    ->action(function (TextBookLoan $record): void {
                        $record->delete();
                        
                        Notification::make()
                            ->title('Permintaan peminjaman berhasil dibatalkan')
                            ->success()
                            ->send();
                    })
            ])
            ->bulkActions([]);
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->role === 'member';
    }
}

