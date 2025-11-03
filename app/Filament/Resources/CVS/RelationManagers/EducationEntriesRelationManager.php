<?php

namespace App\Filament\Resources\CVS\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EducationEntriesRelationManager extends RelationManager
{
    protected static string $relationship = 'educationEntries';

    protected static ?string $title = 'Education';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('qualification')
                            ->label('Degree/Qualification')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Bachelor of Science'),

                        TextInput::make('institution')
                            ->label('Institution/School')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., University of Technology'),

                        TextInput::make('field_of_study')
                            ->label('Field of Study')
                            ->maxLength(255)
                            ->placeholder('e.g., Computer Science'),

                        Select::make('eqf_level')
                            ->label('EQF Level')
                            ->options([
                                1 => 'Level 1 - Basic general knowledge',
                                2 => 'Level 2 - Basic factual knowledge',
                                3 => 'Level 3 - Knowledge of facts, principles',
                                4 => 'Level 4 - Factual and theoretical knowledge',
                                5 => 'Level 5 - Comprehensive knowledge (Short-cycle tertiary)',
                                6 => 'Level 6 - Advanced knowledge (Bachelor)',
                                7 => 'Level 7 - Highly specialized knowledge (Master)',
                                8 => 'Level 8 - Knowledge at forefront of field (Doctorate)',
                            ])
                            ->helperText('European Qualifications Framework Level'),

                        TextInput::make('city')
                            ->maxLength(255),

                        TextInput::make('country')
                            ->maxLength(255),

                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->hidden(fn ($get) => $get('is_current')),

                        Checkbox::make('is_current')
                            ->label('Currently studying here')
                            ->reactive()
                            ->columnSpanFull(),

                        TextInput::make('grade')
                            ->label('Final Grade/GPA')
                            ->maxLength(255)
                            ->placeholder('e.g., 3.8/4.0, First Class Honours'),

                        Textarea::make('description')
                            ->label('Description & Achievements')
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Key courses, achievements, awards, etc.'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('qualification')
            ->columns([
                TextColumn::make('qualification')
                    ->label('Qualification')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('institution')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('field_of_study')
                    ->label('Field')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('eqf_level')
                    ->label('EQF')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('start_date')
                    ->label('Start')
                    ->date()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('End')
                    ->date()
                    ->sortable()
                    ->placeholder('Current'),

                IconColumn::make('is_current')
                    ->label('Current')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('grade')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalWidth('3xl'),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('3xl'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order')
            ->defaultSort('order', 'asc')
            ->paginated(false);
    }
}
