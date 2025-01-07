<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use App\Models\Hotel\Hotel;
use App\Models\Tour\Tour;
use Filament\Forms;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'settings';

    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                MultiSelect::make('hotels')
                    ->label('Select Hotels')
                    ->options(
                        \App\Models\Hotel\Hotel::all()
                            ->mapWithKeys(function ($hotel) {
                                $name = $hotel->names[0]['name'] ?? null;
                                return $name ? [$hotel->id => $name] : [];
                            })
                    )
                    ->placeholder('Choose hotels'),
                MultiSelect::make('tours')
                    ->label('Select Tours')
                    ->options(
                        \App\Models\Tour\Tour::all()
                            ->mapWithKeys(function ($tour) {
                                $title = $tour->titles[0]['title'] ?? null;
                                return $title ? [$tour->id => $title] : [];
                            })
                    )
                    ->placeholder('Choose Tours'),

                FileUpload::make('ad_image')->columnSpanFull()->label('Ad Image'),
                TextInput::make('ad_title_en')->label('Ad Title (English)'),
                TextInput::make('ad_title_ar')->label('Ad Title (Arabic)'),
                Textarea::make('ad_description_en')->label('Ad Description (English)'),
                Textarea::make('ad_description_ar')->label('Ad Description (Arabic)'),
                FileUpload::make('ad2_image')->columnSpanFull()->label('Ad2 Image'),
                TextInput::make('ad2_title_en')->label('Ad2 Title (English)'),
                TextInput::make('ad2_title_ar')->label('Ad2 Title (Arabic)'),
                Textarea::make('ad2_description_en')->label('Ad2 Description (English)'),
                Textarea::make('ad2_description_ar')->label('Ad2 Description (Arabic)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ad_title_en')->label('Ad Title (English)'),
                Tables\Columns\TextColumn::make('ad_title_ar')->label('Ad Title (Arabic)'),
                Tables\Columns\ImageColumn::make('ad_image')->label('Ad Image'),
                Tables\Columns\TextColumn::make('ad2_title_en')->label('Ad2 Title (English)'),
                Tables\Columns\TextColumn::make('ad2_title_ar')->label('Ad2 Title (Arabic)'),
                Tables\Columns\ImageColumn::make('ad2_image')->label('Ad2 Image'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
