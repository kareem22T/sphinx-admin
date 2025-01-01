<?php

namespace App\Filament\Resources\Car;

use App\Filament\Resources\Car\CarResource\Pages;
use App\Filament\Resources\Car\CarResource\RelationManagers;
use App\Models\Car\Car;
use App\Models\Currency;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Tapp\FilamentGoogleAutocomplete\Forms\Components\GoogleAutocomplete;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'car-suv';
    protected static ?string $navigationGroup = 'Car';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        $languages = Language::all(); // Fetch languages
        $currencies = Currency::all(); // Fetch languages

        return $form
            ->schema([
                Forms\Components\Fieldset::make('Car Names')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("car_titles_as_array.{$language->id}")
                                ->label("Name ({$language->name})")
                                ->required();
                        })->toArray()
                    ),

                Forms\Components\Fieldset::make('Car Categories')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("car_types_as_array.{$language->id}")
                                ->label("Category ({$language->name})")
                                ->required();
                        })->toArray()
                    ),

                Forms\Components\Fieldset::make('Car Brief')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\Textarea::make("car_descriptions_as_array.{$language->id}")
                                ->label("Brief ({$language->name})")
                                ->columnSpanFull()
                                ->required();
                        })->toArray()
                    ),

                Forms\Components\Fieldset::make('Car Prices')
                    ->schema(
                        $currencies->map(function ($currency) {
                            return Forms\Components\TextInput::make("package_prices_as_array.{$currency->id}")
                                ->label("Car Price per day in ({$currency->code})")
                                ->required();
                        })->toArray()
                    ),

                GoogleAutocomplete::make('google_search')
                    ->label('Car Location')
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
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                BelongsToManyMultiSelect::make('features')
                    ->relationship('features', 'name') // Relationship and display column
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
                    ->afterStateUpdated(function ($state, callable $set, $record) {
                        if ($state && $record) {
                            foreach ($state as $path) {
                                $record->gallery()->create(['path' => $path]);
                            }
                        }
                    })
                    ->helperText('You can upload multiple images at once.'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lng')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'view' => Pages\ViewCar::route('/{record}'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
