<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Pengguna';

    public static function form(Form $form): Form
    {
    return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->label('Nama')
                ->maxLength(255),
            TextInput::make('email')
                ->email()
                ->required()
                ->label('Email')
                ->maxLength(255),
            Select::make('role')
                ->label('Peran')
                ->options([
                    'admin' => 'Administrator',
                    'employee' => 'Pegawai',
                    'member' => 'Anggota',
                ])
                ->required(),
            TextInput::make('password')
                ->password()
                ->label('Kata Sandi')
                ->dehydrateStateUsing(fn ($state) => !empty($state) ? bcrypt($state) : null)
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn ($context) => $context === 'create'),
        ]);
    }

    public static function table(Table $table): Table
    {
    return $table
        ->columns([
            TextColumn::make('name')
                ->label('Nama')
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->sortable(),
            TextColumn::make('role')
                ->label('Peran')
                ->badge()
                ->colors([
                    'admin' => 'danger',
                    'employee' => 'info',
                    'member' => 'success',
                ])
                ->formatStateUsing(fn ($state) => match($state) {
                    'admin' => 'Administrator',
                    'employee' => 'Pegawai',
                    'member' => 'Anggota',
                    default => ucfirst($state)
                }),
        ])
        ->filters([
            SelectFilter::make('role')
                ->label('Peran')
                ->options([
                    'admin' => 'Administrator',
                    'employee' => 'Pegawai',
                    'member' => 'Anggota',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make()->label('Edit'),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()->label('Hapus Terpilih'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser ::route('/create'),
            'edit' => Pages\EditUser ::route('/{record}/edit'),
        ];
    }
    public static function canViewAny(): bool
    {
        return auth()->user()->role === 'admin';
    }
}
