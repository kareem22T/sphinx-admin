<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 13;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('coupon_code')
                    ->label('Coupon Code')
                    ->required(),

                TextInput::make('title')
                    ->label('Title')
                    ->required(),

                TextInput::make('description')
                    ->label('Description')
                    ->required(),

                TextInput::make('discount_percentage')
                    ->numeric()
                    ->label('Discount Percentage')
                    ->required(),

                DateTimePicker::make('start_date')
                    ->label('Start Date')
                    ->required(),

                DateTimePicker::make('end_date')
                    ->label('End Date')
                    ->required(),
                BelongsToSelect::make('hotel_id')
                    ->relationship('hotel', 'name')
                    ->label('Select Hotel')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(fn($state, $set) => $set('tour_id', null)) // Clear tour if hotel is selected
                    ->nullable(),

                BelongsToSelect::make('tour_id')
                    ->relationship('tours', 'title')
                    ->label('Select Tour')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(fn($state, $set) => $set('hotel_id', null)) // Clear hotel if tour is selected
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('coupon_code')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('discount_percentage')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'view' => Pages\ViewCoupon::route('/{record}'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
