<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReasonResource\Pages;
use App\Filament\Resources\ReasonResource\RelationManagers;
use App\Models\Language;
use App\Models\Reason;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReasonResource extends Resource
{
    protected static ?string $model = Reason::class;

    protected static ?string $navigationIcon = 'heart-question';
    protected static ?string $navigationGroup = 'Hotel';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        $languages = Language::all(); // Fetch languages

        return $form
            ->schema([
                Forms\Components\FileUpload::make('icon_path')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Fieldset::make('Reasons Names')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("reasons_names_as_array.{$language->id}")
                                ->label("Name ({$language->name})")
                                ->required();
                        })->toArray()
                    ),
                Forms\Components\Fieldset::make('Reasons Description')
                    ->schema(
                        $languages->map(function ($language) {
                            return Forms\Components\TextInput::make("reasons_descriptions_as_array.{$language->id}")
                                ->label("Description ({$language->name})")
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
            'index' => Pages\ListReasons::route('/'),
            'create' => Pages\CreateReason::route('/create'),
            'view' => Pages\ViewReason::route('/{record}'),
            'edit' => Pages\EditReason::route('/{record}/edit'),
        ];
    }
}
