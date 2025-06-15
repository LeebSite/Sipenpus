<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TextBookResource\Pages;
use App\Models\TextBook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TextBookResource extends Resource
{
    protected static ?string $model = TextBook::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Buku Cetak';
    protected static ?string $navigationGroup = 'Manajemen Buku';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->label('Judul Buku')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kode_buku')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Kode Buku')
                    ->maxLength(50),
                Forms\Components\TextInput::make('mata_pelajaran')
                    ->required()
                    ->label('Mata Pelajaran')
                    ->maxLength(100),
                Forms\Components\TextInput::make('kelas')
                    ->required()
                    ->label('Kelas')
                    ->maxLength(50),
                Forms\Components\TextInput::make('penulis')
                    ->required()
                    ->label('Penulis')
                    ->maxLength(100),
                Forms\Components\TextInput::make('penerbit')
                    ->required()
                    ->label('Penerbit')
                    ->maxLength(100),
                Forms\Components\TextInput::make('tahun_terbit')
                    ->required()
                    ->label('Tahun Terbit')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y')),
                Forms\Components\TextInput::make('stok')
                    ->required()
                    ->label('Stok')
                    ->numeric()
                    ->minValue(0),
                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('gambar')
                    ->image()
                    ->directory('textbooks')
                    ->disk('public')
                    ->visibility('public')
                    ->label('Gambar Buku'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->circular()
                    ->defaultImageUrl(fn () => asset('images/default-book.png')),
                Tables\Columns\TextColumn::make('kode_buku')
                    ->label('Kode Buku')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('mata_pelajaran')
                    ->label('Mata Pelajaran')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('penulis')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('penerbit')
                    ->label('Penerbit')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tahun_terbit')
                    ->label('Tahun Terbit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kelas')
                    ->options([
                        'X' => 'Kelas X',
                        'XI' => 'Kelas XI',
                        'XII' => 'Kelas XII',
                    ]),
                Tables\Filters\SelectFilter::make('mata_pelajaran')
                    ->options([
                        'Matematika' => 'Matematika',
                        'Bahasa Indonesia' => 'Bahasa Indonesia',
                        'Bahasa Inggris' => 'Bahasa Inggris',
                        'IPA' => 'IPA',
                        'IPS' => 'IPS',
                        'Sejarah' => 'Sejarah',
                        'Fisika' => 'Fisika',
                        'Kimia' => 'Kimia',
                        'Biologi' => 'Biologi',
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
            'index' => Pages\ListTextBook::route('/'),
            'create' => Pages\CreateTextBook::route('/create'),
            'edit' => Pages\EditTextBook::route('/{record}/edit'),
        ];
    }
    
    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin' || auth()->user()->role === 'employee';
    }
}


