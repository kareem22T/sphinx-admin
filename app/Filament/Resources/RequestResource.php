<?php

namespace App\Filament\Resources;

use App\Models\Booking\Request as BookingRequest;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\RequestResource\Pages\ListRequests;

class RequestResource extends Resource
{
    protected static ?string $model = BookingRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function table(Table $table): Table
    {
        return $table
            ->poll('5s') // Poll the table every 5 seconds
            ->columns([
                TextColumn::make('id')
                    ->label('Request ID')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime(),
            ])
            ->defaultSort('created_at', 'desc'); // Default sorting to show the newest first
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('status')
                    ->label('Status')
                    ->required(),

                // Booking Details Fields
                TextInput::make('booking_details.tour')
                    ->label('Tour Name')
                    ->required()
                    ->disabled(),

                TextInput::make('booking_details.tour_id')
                    ->label('Tour ID')
                    ->required()
                    ->disabled(),

                TextInput::make('booking_details.package')
                    ->label('Package')
                    ->required()
                    ->disabled(),

                TextInput::make('booking_details.phone')
                    ->label('Phone')
                    ->required()
                    ->disabled(),

                TextInput::make('booking_details.start')
                    ->label('Start Date')
                    ->required()
                    ->disabled(),

                TextInput::make('booking_details.persons')
                    ->label('Persons')
                    ->required()
                    ->disabled(),

                TextInput::make('booking_details.price')
                    ->label('Price')
                    ->required()
                    ->disabled(),

                TextInput::make('booking_details.type')
                    ->label('Type')
                    ->required()
                    ->disabled(),

                Textarea::make('booking_details.more')
                    ->label('More Details')
                    ->rows(3)
                    ->disabled(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRequests::route('/'),
        ];
    }
}
