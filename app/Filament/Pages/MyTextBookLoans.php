<?php

namespace App\Filament\Pages;

use App\Models\TextBookLoan;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MyTextBookLoans extends Page implements HasTable
{
    use InteractsWithTable;
    
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Peminjaman Buku Cetak Saya';
    protected static ?string $navigationGroup = 'Perpustakaan';
    protected static ?int $navigationSort = 4;
    protected static string $view = 'filament.pages.my-text-book-loans';
    
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
                        'primary' => 'returned',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu Persetujuan',
                        'active' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                        'rejected' => 'Ditolak',
                        default => $state,
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}

