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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
    return $form
        ->schema([
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
            Select::make('role')
                ->label('Role')
                ->options([
                    'admin' => 'Admin',
                    'employee' => 'Employee',
                    'member' => 'Member',
                ])
                ->required(),
            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => !empty($state) ? bcrypt($state) : null)
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn ($context) => $context === 'create'),
        ]);
    }

    public static function table(Table $table): Table
    {
    return $table
        ->columns([
            TextColumn::make('name')->label('Nama')->searchable(),
            TextColumn::make('email')->label('Email')->searchable(),
            TextColumn::make('role')
                ->label('Peran')
                ->badge()
                ->colors([
                    'admin' => 'danger',
                    'employee' => 'info',
                    'member' => 'success',
                ])
                ->formatStateUsing(fn ($state) => ucfirst($state)),
        ])
        ->filters([
            SelectFilter::make('role')
                ->options([
                    'admin' => 'Admin',
                    'employee' => 'Employee',
                    'member' => 'Member',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Peran')
                    ->badge()
                    ->colors([
                        'admin' => 'danger',
                        'employee' => 'info',
                        'member' => 'success',
                    ])
                    ->formatStateUsing(fn ($state) => ucfirst($state)),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'employee' => 'Employee',
                        'member' => 'Member',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
