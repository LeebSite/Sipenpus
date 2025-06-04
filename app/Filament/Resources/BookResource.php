<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Library Management';
    protected static ?string $navigationLabel = 'Books';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_buku')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Kode Buku'),
                TextInput::make('isbn')
                    ->label('ISBN')
                    ->unique(ignoreRecord: true),
                TextInput::make('judul')
                    ->required()
                    ->label('Judul Buku'),
                TextInput::make('penulis')
                    ->required()
                    ->label('Penulis'),
                TextInput::make('penerbit')
                    ->required()
                    ->label('Penerbit'),
                DatePicker::make('tanggal_terbit')
                    ->required()
                    ->label('Tanggal Terbit'),
                TextInput::make('jumlah_halaman')
                    ->numeric()
                    ->required()
                    ->label('Jumlah Halaman'),
                Select::make('kategori')
                    ->options([
                        'novel' => 'Novel',
                        'fiksi' => 'Fiksi',
                        'filsafat' => 'Filsafat',
                        'fiksi' => 'Fiksi',
                        'komik' => 'Komik',
                        'ilmiah' => 'Ilmiah',
                    ])
                    ->required(),
                FileUpload::make('gambar')
                    ->image()
                    ->directory('books')
                    ->disk('public')
                    ->visibility('public')
                    ->label('Gambar Buku'),
                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable',
                    ])
                    ->required()
                    ->default('available'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('gambar')
                    ->label('Gambar')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return 'No Image';
                        
                        // Gunakan URL absolut
                        $url = asset('storage/' . $state);
                        return "<img src='{$url}' width='50' height='50' style='border-radius: 50%'>";
                    })
                    ->html(),
                TextColumn::make('kode_buku')
                    ->label('Kode Buku')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('isbn')
                    ->searchable(),
                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('penulis')
                    ->searchable(),
                TextColumn::make('kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'novel' => 'info',
                        'fiksi' => 'info',
                        'filsafat' => 'info',
                        'fiksi' => 'info',
                        'komik' => 'info',
                        'ilmiah' => 'info',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'unavailable' => 'danger',
                    }),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->options([
                        'novel' => 'Novel',
                        'komik' => 'Komik',
                        'ilmiah' => 'Ilmiah',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}




