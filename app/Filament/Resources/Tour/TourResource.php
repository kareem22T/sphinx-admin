<?php

namespace App\Filament\Resources\Tour;

use App\Filament\Resources\Tour\TourResource\Pages;
use App\Filament\Resources\Tour\TourResource\RelationManagers;
use App\Filament\Resources\TourResource\RelationManagers\DaysRelationManager;
use App\Filament\Resources\TourResource\RelationManagers\PackagesRelationManager;
use App\Models\Language;
use App\Models\Tour\Tour;
use Filament\Forms;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'plane-departure';
    protected static ?string $navigationGroup = 'Tours';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $languages = Language::all(); // Fetch languages

        return $form
            ->schema([
                Forms\Components\Fieldset::make('Tour Titles')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("tours_titles_as_array.{$language->id}")
                                ->label("Title ({$language->name})")
                                ->required();
                        })->toArray()
                    ),

                Forms\Components\Fieldset::make('Intros')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("intros_as_array.{$language->id}")
                                ->label("Intro ({$language->name})")
                                ->required();
                        })->toArray()
                    ),

                Forms\Components\Fieldset::make('Locations')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("locations_as_array.{$language->id}")
                                ->label("Location ({$language->name})")
                                ->required();
                        })->toArray()
                    ),

                Forms\Components\Fieldset::make('Transportation')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("transportation_as_array.{$language->id}")
                                ->label("Transportation ({$language->name})")
                                ->required();
                        })->toArray()
                    ),

                Select::make('destination_id')
                    ->label('Destination')
                    ->relationship('destination', 'name_en') // Assuming 'name' is the column to display
                    ->required(),
                BelongsToManyMultiSelect::make('activities')
                    ->relationship('activities', 'name_en') // Relationship and display column
                    ->required(),


                Forms\Components\TextInput::make('expired_date')
                    ->label('Tour Expired date')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('duration')
                    ->label('Tour Duration in days')
                    ->required()
                    ->numeric()
                    ->default(12),
                Forms\Components\TextInput::make('min_participant')
                    ->label('Tour Min Participants')
                    ->required()
                    ->numeric()
                    ->default(12),
                Forms\Components\TextInput::make('max_participant')
                    ->label('Tour Max Participants')
                    ->required()
                    ->numeric()
                    ->default(12),
                Forms\Components\Fieldset::make('Includes')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\Textarea::make("includes_as_array.{$language->id}")
                                ->label("Include ({$language->name})")
                                ->columnSpanFull()
                                ->required();
                        })->toArray()
                    ),

                Forms\Components\Fieldset::make('Excludes')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\Textarea::make("excludes_as_array.{$language->id}")
                                ->label("Exclude ({$language->name})")
                                ->columnSpanFull()
                                ->required();
                        })->toArray()
                    ),
                SpatieMediaLibraryFileUpload::make('images')
                    ->required()
                    ->label('Gallery Images')
                    ->multiple() // Allow multiple file uploads
                    ->directory('Tours_gallery') // Specify upload directory
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
                Tables\Columns\TextColumn::make('first_name'),
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
            DaysRelationManager::class,
            PackagesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'view' => Pages\ViewTour::route('/{record}'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }
}
