<?php

namespace App\Filament\Resources\CVS\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SkillsRelationManager extends RelationManager
{
    protected static string $relationship = 'skills';

    protected static ?string $title = 'Skills';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Skill Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Laravel, React, Project Management'),

                        Select::make('category')
                            ->required()
                            ->options([
                                'digital' => 'Digital Skills',
                                'technical' => 'Technical Skills',
                                'professional' => 'Professional Skills',
                                'other' => 'Other Skills',
                            ])
                            ->default('other'),

                        Select::make('proficiency_level')
                            ->label('Proficiency Level')
                            ->options([
                                'beginner' => 'Beginner',
                                'intermediate' => 'Intermediate',
                                'advanced' => 'Advanced',
                                'expert' => 'Expert',
                            ]),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(2)
                            ->columnSpanFull()
                            ->placeholder('Brief description of your expertise with this skill'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Skill')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'digital' => 'info',
                        'technical' => 'success',
                        'professional' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('proficiency_level')
                    ->label('Level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'expert' => 'success',
                        'advanced' => 'info',
                        'intermediate' => 'warning',
                        'beginner' => 'gray',
                        default => 'gray',
                    }),
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
