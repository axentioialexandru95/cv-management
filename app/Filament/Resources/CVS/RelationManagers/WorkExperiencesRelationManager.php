<?php

namespace App\Filament\Resources\CVS\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkExperiencesRelationManager extends RelationManager
{
    protected static string $relationship = 'workExperiences';

    protected static ?string $title = 'Work Experience';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('job_title')
                            ->label('Job Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Senior Software Engineer'),

                        TextInput::make('employer')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Tech Company Inc.'),

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
                            ->label('I currently work here')
                            ->reactive()
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Description & Responsibilities')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Describe your key responsibilities and achievements.'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('job_title')
            ->columns([
                TextColumn::make('job_title')
                    ->label('Job Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('employer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('city')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('country')
                    ->searchable()
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
