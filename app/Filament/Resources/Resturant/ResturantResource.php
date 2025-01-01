<?php

namespace App\Filament\Resources\Resturant;

use App\Filament\Resources\Resturant\ResturantResource\Pages;
use App\Filament\Resources\Resturant\ResturantResource\RelationManagers;
use App\Models\Language;
use App\Models\Resturant\Resturant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Tapp\FilamentGoogleAutocomplete\Forms\Components\GoogleAutocomplete;

class ResturantResource extends Resource
{
    protected static ?string $model = Resturant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $languages = Language::all(); // Fetch languages

        return $form
            ->schema([
                Forms\Components\FileUpload::make('thumbnail')
                    ->required()
                    ->image()
                    ->columnSpanFull(),
                Forms\Components\Fieldset::make('Restaurant Titles')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("resturants_titles_as_array.{$language->id}")
                                ->label("Title ({$language->name})")
                                ->required();
                        })->toArray()
                    ),
                Forms\Components\Fieldset::make('Restaurant Descriptions')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\Textarea::make("resturants_descriptions_as_array.{$language->id}")
                                ->label("Description ({$language->name})")
                                ->required();
                        })->toArray()
                    ),

                GoogleAutocomplete::make('google_search')
                    ->label('Restaurant Address')
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('c'),
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
            'index' => Pages\ListResturants::route('/'),
            'create' => Pages\CreateResturant::route('/create'),
            'view' => Pages\ViewResturant::route('/{record}'),
            'edit' => Pages\EditResturant::route('/{record}/edit'),
        ];
    }
}
