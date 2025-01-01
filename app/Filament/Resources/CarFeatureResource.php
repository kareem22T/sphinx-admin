<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarFeatureResource\Pages;
use App\Filament\Resources\CarFeatureResource\RelationManagers;
use App\Models\CarFeature;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarFeatureResource extends Resource
{
    protected static ?string $model = CarFeature::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Cars';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $languages = Language::all(); // Fetch languages

        return $form
            ->schema([
                Forms\Components\FileUpload::make('icon_path')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Fieldset::make('Feature Names')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("features_names_as_array.{$language->id}")
                                ->label("Name ({$language->name})")
                                ->required();
                        })->toArray()
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
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
            'index' => Pages\ListCarFeatures::route('/'),
            'create' => Pages\CreateCarFeature::route('/create'),
            'view' => Pages\ViewCarFeature::route('/{record}'),
            'edit' => Pages\EditCarFeature::route('/{record}/edit'),
        ];
    }
}
