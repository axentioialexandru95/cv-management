<?php

namespace App\Filament\Resources\Languages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LanguageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->autocomplete(false),
                TextInput::make('code')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true)
                    ->autocomplete(false)
                    ->helperText('ISO 639-1 language code (e.g., en, es, fr)'),
            ]);
    }
}
