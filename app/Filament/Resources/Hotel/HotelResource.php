<?php

namespace App\Filament\Resources\Hotel;

use App\Filament\Resources\Hotel\HotelResource\Pages;
use App\Filament\Resources\Hotel\HotelResource\RelationManagers;
use App\Filament\Resources\Hotel\HotelResource\RelationManagers\RoomsRelationManager;
use App\Forms\Components\GooglePlacesField;
use App\Forms\Components\LocationPicker;
use App\Models\Hotel\Hotel;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Tapp\FilamentGoogleAutocomplete\Forms\Components\GoogleAutocomplete;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;

    protected static ?string $navigationIcon = 'building-skyscraper';
    protected static ?string $navigationGroup = 'Hotel';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        $languages = Language::all(); // Fetch languages

        return $form
            ->schema([
                Forms\Components\Fieldset::make('Hotel Names')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("hotel_names_as_array.{$language->id}")
                                ->label("Name ({$language->name})")
                                ->required();
                        })->toArray()
                    ),
                Forms\Components\Fieldset::make('Hotel Descriptions')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\Textarea::make("hotel_descriptions_as_array.{$language->id}")
                                ->label("Description ({$language->name})")
                                ->columnSpanFull()
                                ->required();
                        })->toArray()
                    ),
                Forms\Components\Fieldset::make('Hotel Slogans')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("hotel_slogans_as_array.{$language->id}")
                                ->label("Slogan ({$language->name})")
                                ->required();
                        })->toArray()
                    ),
                Forms\Components\Fieldset::make('Hotel Addresses')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("hotel_addresses_as_array.{$language->id}")
                                ->label("Address ({$language->name})")
                                ->required();
                        })->toArray()
                    ),
                Select::make('destination_id')
                    ->label('Destination')
                    ->relationship('destination', 'name_en') // Assuming 'name' is the column to display
                    ->required(),
                Select::make('type')
                    ->label('Type')
                    ->options([
                        'hotel' => 'Hotel',
                        'cottage' => 'Cottage',
                    ])
                    ->placeholder('Select a type')
                    ->required(),
                TextInput::make('phone')->columnSpanFull()->required(),
                TextInput::make('hotel_rate')->numeric()->required(),
                TextInput::make('check_in')->required(),
                TextInput::make('check_out')->required(),
                GoogleAutocomplete::make('google_search')
                    ->label('Hotel Address')
                    ->autocompleteSearchDebounce(500)
                    ->withFields([
                        Forms\Components\TextInput::make('address')
                            ->readonly()
                            ->columnSpanFull()
                            ->extraInputAttributes([
                                'data-google-field' => '{formatted_address}',
                            ]),
                        Forms\Components\TextInput::make('lat')
                            ->readonly()
                            ->extraInputAttributes([
                                'data-google-field' => '{latitude}',
                            ]),
                        Forms\Components\TextInput::make('lng')
                            ->readonly()
                            ->extraInputAttributes([
                                'data-google-field' => '{longitude}',
                            ]),
                    ]),
                BelongsToManyMultiSelect::make('features')
                    ->relationship('features', 'name') // Relationship and display column
                    ->required(),
                BelongsToManyMultiSelect::make('reasons')
                    ->relationship('reasons', 'name') // Relationship and display column
                    ->required(),
                BelongsToManyMultiSelect::make('tours')
                    ->relationship('tours', 'title') // Relationship and display column
                    ->columnSpanFull()
                    ->required(),
                SpatieMediaLibraryFileUpload::make('images')
                    ->required()
                    ->label('Gallery Images')
                    ->multiple() // Allow multiple file uploads
                    ->directory('gallery') // Specify upload directory
                    ->image() // Restrict to image files
                    ->columnSpanFull()
                    ->disk('public')
                    ->panelLayout('grid') // Display uploaded images in a 3-column grid
                    // ->afterStateUpdated(function ($state, callable $set, $record) {
                    //     if ($state && $record) {
                    //         foreach ($state as $path) {
                    //             $record->gallery()->create(['path' => $path]);
                    //         }
                    //     }
                    // })
                    ->helperText('You can upload multiple images at once.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gallery.path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('check_in')
                    ->searchable(),
                Tables\Columns\TextColumn::make('check_out')
                    ->searchable(),
                Tables\Columns\TextColumn::make('avg_rating')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            RoomsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotels::route('/'),
            'create' => Pages\CreateHotel::route('/create'),
            'view' => Pages\ViewHotel::route('/{record}'),
            'edit' => Pages\EditHotel::route('/{record}/edit'),
        ];
    }
}
