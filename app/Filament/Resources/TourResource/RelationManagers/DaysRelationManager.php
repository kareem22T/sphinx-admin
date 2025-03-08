<?php

namespace App\Filament\Resources\TourResource\RelationManagers;

use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class DaysRelationManager extends RelationManager
{
    protected static string $relationship = 'days';

    public function form(Form $form): Form
    {
        $languages = Language::all(); // Fetch languages

        return $form
            ->schema([
                FileUpload::make('thumbnail')->image(),
                Forms\Components\Fieldset::make('Day Titles')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("day_titles_as_array.{$language->id}")
                                ->label("Title ({$language->name})")
                                ->required();
                        })->toArray()
                    ),
                Forms\Components\Fieldset::make('Day Descriptions')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\Textarea::make("day_descriptions_as_array.{$language->id}")
                                ->label("Description ({$language->name})")
                                ->columnSpanFull()
                                ->required();
                        })->toArray()
                    ),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('thumbnail')
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('first_title')->label('Title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record, $data) {

                        foreach ($data['day_titles_as_array'] as $languageId => $title) {
                            $record->titles()->create([
                                'language_id' => $languageId,
                                'title' => $title,
                            ]);
                        }
                        foreach ($data['day_descriptions_as_array'] as $languageId => $description) {
                            $record->descriptions()->create([
                                'language_id' => $languageId,
                                'description' => $description,
                            ]);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->after(function ($record, $data) {
                    // Handle day titles
                    foreach ($data['day_titles_as_array'] as $languageId => $title) {
                        $dayTitle = $record->titles()->firstOrNew([
                            'language_id' => $languageId,
                        ]);

                        $dayTitle->title = $title;
                        $dayTitle->save();

                        // Delete any other records except the one just saved
                        $record->titles()
                            ->where('language_id', $languageId)
                            ->where('id', '!=', $dayTitle->id)
                            ->delete();
                    }

                    // Handle day descriptions
                    foreach ($data['day_descriptions_as_array'] as $languageId => $description) {
                        $dayDescription = $record->descriptions()->firstOrNew([
                            'language_id' => $languageId,
                        ]);

                        $dayDescription->description = $description;
                        $dayDescription->save();

                        // Delete any other records except the one just saved
                        $record->descriptions()
                            ->where('language_id', $languageId)
                            ->where('id', '!=', $dayDescription->id)
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
