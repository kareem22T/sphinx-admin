<?php

namespace App\Filament\Resources\Hotel\HotelResource\RelationManagers;

use App\Models\Currency;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Container\Attributes\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log as FacadesLog;

class RoomsRelationManager extends RelationManager
{
    protected static string $relationship = 'rooms';

    public function form(Form $form): Form
    {
        $languages = Language::all(); // Fetch languages
        $currencies = Currency::all(); // Fetch languages

        return $form
            ->schema([
                Forms\Components\Fieldset::make('Room Names')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("room_names_as_array.{$language->id}")
                                ->label("Name ({$language->name})")
                                ->required();
                        })->toArray()
                    ),
                Forms\Components\Fieldset::make('Room Descriptions')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\Textarea::make("room_descriptions_as_array.{$language->id}")
                                ->label("Description ({$language->name})")
                                ->columnSpanFull()
                                ->required();
                        })->toArray()
                    ),
                Forms\Components\Fieldset::make('Room Prices')
                    ->schema(
                        $currencies->map(function ($currency) {
                            return Forms\Components\TextInput::make("room_prices_as_array.{$currency->id}")
                                ->label("Price in ({$currency->code})")
                                ->required();
                        })->toArray()
                    ),
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

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->label('Name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record, $data) {

                        foreach ($data['room_names_as_array'] as $languageId => $name) {
                            $record->names()->create([
                                'language_id' => $languageId,
                                'name' => $name,
                            ]);
                        }
                        foreach ($data['room_descriptions_as_array'] as $languageId => $description) {
                            $record->descriptions()->create([
                                'language_id' => $languageId,
                                'description' => $description,
                            ]);
                        }
                        foreach ($data['room_prices_as_array'] as $currencyId => $price) {
                            $record->prices()->create([
                                'currency_id' => $currencyId,
                                'price' => $price,
                            ]);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function ($record, $data) {
                        FacadesLog::info($data['room_prices_as_array']);
                        foreach ($data['room_names_as_array'] as $languageId => $name) {
                            $roomName = $record->names()->firstOrNew([
                                'language_id' => $languageId,
                            ]);

                            $roomName->name = $name;
                            $roomName->save();
                        }
                        foreach ($data['room_descriptions_as_array'] as $languageId => $description) {
                            $roomdescription = $record->descriptions()->firstOrNew([
                                'language_id' => $languageId,
                            ]);

                            $roomdescription->description = $description;
                            $roomdescription->save();
                        }
                        foreach ($data['room_prices_as_array'] as $currencyId => $price) {
                            $roomprice = $record->prices()->firstOrNew([
                                'currency_id' => $currencyId,
                            ]);

                            FacadesLog::info($roomprice);

                            $roomprice->price = $price;
                            $roomprice->save();
                        }
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
