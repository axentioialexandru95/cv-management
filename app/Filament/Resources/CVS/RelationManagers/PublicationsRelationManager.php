<?php

namespace App\Filament\Resources\CVS\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PublicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'publications';

    protected static ?string $title = 'Publications';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->label('Publication Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('e.g., Machine Learning Approaches to...'),

                        Select::make('publication_type')
                            ->label('Type')
                            ->required()
                            ->options([
                                'journal' => 'Journal Article',
                                'conference' => 'Conference Paper',
                                'book' => 'Book',
                                'chapter' => 'Book Chapter',
                                'other' => 'Other',
                            ])
                            ->default('other'),

                        DatePicker::make('publication_date')
                            ->label('Publication Date')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Textarea::make('authors')
                            ->label('Authors')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull()
                            ->placeholder('List all authors (e.g., Smith, J., Doe, A., ...)')
                            ->helperText('Include all authors in proper citation format'),

                        TextInput::make('publication_venue')
                            ->label('Publication Venue')
                            ->maxLength(255)
                            ->placeholder('e.g., IEEE Transactions on..., ICML 2024'),

                        TextInput::make('doi')
                            ->label('DOI')
                            ->maxLength(255)
                            ->placeholder('e.g., 10.1000/xyz123'),

                        TextInput::make('url')
                            ->label('Publication URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://...'),

                        Textarea::make('description')
                            ->label('Abstract/Description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Publication')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                TextColumn::make('publication_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'journal' => 'success',
                        'conference' => 'info',
                        'book' => 'warning',
                        'chapter' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('publication_venue')
                    ->label('Venue')
                    ->searchable()
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('publication_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('doi')
                    ->label('DOI')
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
