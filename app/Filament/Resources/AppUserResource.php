<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppUserResource\Pages;
use App\Filament\Resources\AppUserResource\RelationManagers;
use App\Models\AppUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppUserResource extends Resource
{
    protected static ?string $model = AppUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email_otp')
                    ->email()
                    ->maxLength(255),
                Forms\Components\Toggle::make('email_verified')
                    ->required(),
                Forms\Components\DateTimePicker::make('email_otp_expires_at'),
                Forms\Components\TextInput::make('phone_otp')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\Toggle::make('phone_verified')
                    ->required(),
                Forms\Components\DateTimePicker::make('phone_otp_expires_at'),
                Forms\Components\Toggle::make('is_prenium')
                    ->required(),
                Forms\Components\DateTimePicker::make('prenium_expires_at'),
                Forms\Components\TextInput::make('stripe_customer_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('stripe_subscription_id')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_otp')
                    ->searchable(),
                Tables\Columns\IconColumn::make('email_verified')
                    ->boolean(),
                Tables\Columns\TextColumn::make('email_otp_expires_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_otp')
                    ->searchable(),
                Tables\Columns\IconColumn::make('phone_verified')
                    ->boolean(),
                Tables\Columns\TextColumn::make('phone_otp_expires_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_prenium')
                    ->boolean(),
                Tables\Columns\TextColumn::make('prenium_expires_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stripe_customer_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stripe_subscription_id')
                    ->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListAppUsers::route('/'),
            'create' => Pages\CreateAppUser::route('/create'),
            'edit' => Pages\EditAppUser::route('/{record}/edit'),
        ];
    }
}
