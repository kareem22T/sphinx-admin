<?php

namespace App\Filament\Resources\TourResource\RelationManagers;

use App\Models\Currency;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class PackagesRelationManager extends RelationManager
{
    protected static string $relationship = 'packages';

    public function form(Form $form): Form
    {
        $languages = Language::all(); // Fetch languages
        $currencies = Currency::all(); // Fetch languages

        return $form
            ->schema([
                Forms\Components\Fieldset::make('Package Titles')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("package_titles_as_array.{$language->id}")
                                ->label("Title ({$language->name})")
                                ->required();
                        })->toArray()
                    ),
                Forms\Components\Fieldset::make('Package Descriptions')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\Textarea::make("package_descriptions_as_array.{$language->id}")
                                ->label("Description ({$language->name})")
                                ->columnSpanFull()
                                ->required();
                        })->toArray()
                    ),
                Forms\Components\Fieldset::make('Package Prices')
                    ->schema(
                        $currencies->map(function ($currency) {
                            return Forms\Components\TextInput::make("package_prices_as_array.{$currency->id}")
                                ->label("Price in ({$currency->code})")
                                ->required();
                        })->toArray()
                    ),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tour_id')
            ->columns([
                Tables\Columns\TextColumn::make('first_title')->label('Title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record, $data) {
                        Log::info($data);

                        foreach ($data['package_titles_as_array'] as $languageId => $title) {
                            $record->titles()->create([
                                'language_id' => $languageId,
                                'title' => $title,
                            ]);
                        }
                        foreach ($data['package_descriptions_as_array'] as $languageId => $description) {
                            $record->descriptions()->create([
                                'language_id' => $languageId,
                                'description' => $description,
                            ]);
                        }
                        foreach ($data['package_prices_as_array'] as $currencyId => $price) {
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
                    Log::info($data);

                    // Handle package titles
                    foreach ($data['package_titles_as_array'] as $languageId => $title) {
                        $packageTitle = $record->titles()->firstOrNew([
                            'language_id' => $languageId,
                        ]);

                        $packageTitle->title = $title;
                        $packageTitle->save();

                        // Delete any other records except the one just saved
                        $record->titles()
                            ->where('language_id', $languageId)
                            ->where('id', '!=', $packageTitle->id)
                            ->delete();
                    }

                    // Handle package descriptions
                    foreach ($data['package_descriptions_as_array'] as $languageId => $description) {
                        $packageDescription = $record->descriptions()->firstOrNew([
                            'language_id' => $languageId,
                        ]);

                        $packageDescription->description = $description;
                        $packageDescription->save();

                        // Delete any other records except the one just saved
                        $record->descriptions()
                            ->where('language_id', $languageId)
                            ->where('id', '!=', $packageDescription->id)
                            ->delete();
                    }

                    // Handle package prices
                    foreach ($data['package_prices_as_array'] as $currencyId => $price) {
                        $packagePrice = $record->prices()->firstOrNew([
                            'currency_id' => $currencyId,
                        ]);

                        $packagePrice->price = $price;
                        $packagePrice->save();

                        // Delete any other records except the one just saved
                        $record->prices()
                            ->where('currency_id', $currencyId)
                            ->where('id', '!=', $packagePrice->id)
                            ->delete();
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
