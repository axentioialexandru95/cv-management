<?php

namespace App\Filament\Resources\CVS\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'projects';

    protected static ?string $title = 'Projects';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->label('Project Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., E-commerce Platform Redesign'),

                        TextInput::make('role')
                            ->label('Your Role')
                            ->maxLength(255)
                            ->placeholder('e.g., Lead Developer, Project Manager'),

                        Checkbox::make('is_ongoing')
                            ->label('Ongoing Project')
                            ->reactive()
                            ->columnSpanFull(),

                        TextInput::make('url')
                            ->label('Project URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://...'),

                        TagsInput::make('technologies')
                            ->label('Technologies Used')
                            ->placeholder('Add technology (press Enter)')
                            ->columnSpanFull()
                            ->helperText('Enter technologies/tools used in this project'),

                        Textarea::make('description')
                            ->label('Project Description')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Describe the project, your contributions, and key achievements.'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Project')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('role')
                    ->searchable()
                    ->toggleable(),

                IconColumn::make('is_ongoing')
                    ->label('Ongoing')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('technologies')
                    ->badge()
                    ->separator(',')
                    ->limit(3)
                    ->toggleable(),

                TextColumn::make('url')
                    ->label('URL')
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab()
                    ->toggleable()
                    ->limit(30),
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
