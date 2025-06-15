<?php

namespace App\Filament\Pages;

use App\Models\Loan;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class MemberLoans extends Page implements HasTable
{
    use InteractsWithTable;
    
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Peminjaman Buku Saya';
    protected static ?string $title = 'Peminjaman Buku Saya';
    protected static ?string $navigationGroup = 'Transaksi Saya';
    
    protected static string $view = 'filament.pages.member-loans';
    
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
                Loan::query()->where('user_id', Auth::id())
            )
            ->columns([
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu Persetujuan',
                        'active' => 'Dipinjam',
                        'returned' => 'Dikembalikan',
                        'rejected' => 'Ditolak',
                        'overdue' => 'Terlambat',
                    ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->role === 'member';
    }
}

