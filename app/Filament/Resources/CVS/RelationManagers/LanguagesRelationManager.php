<?php

namespace App\Filament\Resources\CVS\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LanguagesRelationManager extends RelationManager
{
    protected static string $relationship = 'languages';

    protected static ?string $title = 'Languages';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->columnSpanFull()
                    ->schema([
                        Checkbox::make('is_native')
                            ->label('Native Language')
                            ->reactive()
                            ->columnSpanFull(),

                        Select::make('listening')
                            ->label('Listening')
                            ->options([
                                'A1' => 'A1 - Beginner',
                                'A2' => 'A2 - Elementary',
                                'B1' => 'B1 - Intermediate',
                                'B2' => 'B2 - Upper Intermediate',
                                'C1' => 'C1 - Advanced',
                                'C2' => 'C2 - Proficient',
                            ])
                            ->hidden(fn ($get) => $get('is_native')),

                        Select::make('reading')
                            ->label('Reading')
                            ->options([
                                'A1' => 'A1 - Beginner',
                                'A2' => 'A2 - Elementary',
                                'B1' => 'B1 - Intermediate',
                                'B2' => 'B2 - Upper Intermediate',
                                'C1' => 'C1 - Advanced',
                                'C2' => 'C2 - Proficient',
                            ])
                            ->hidden(fn ($get) => $get('is_native')),

                        Select::make('spoken_interaction')
                            ->label('Spoken Interaction')
                            ->options([
                                'A1' => 'A1 - Beginner',
                                'A2' => 'A2 - Elementary',
                                'B1' => 'B1 - Intermediate',
                                'B2' => 'B2 - Upper Intermediate',
                                'C1' => 'C1 - Advanced',
                                'C2' => 'C2 - Proficient',
                            ])
                            ->hidden(fn ($get) => $get('is_native')),

                        Select::make('spoken_production')
                            ->label('Spoken Production')
                            ->options([
                                'A1' => 'A1 - Beginner',
                                'A2' => 'A2 - Elementary',
                                'B1' => 'B1 - Intermediate',
                                'B2' => 'B2 - Upper Intermediate',
                                'C1' => 'C1 - Advanced',
                                'C2' => 'C2 - Proficient',
                            ])
                            ->hidden(fn ($get) => $get('is_native')),

                        Select::make('writing')
                            ->label('Writing')
                            ->options([
                                'A1' => 'A1 - Beginner',
                                'A2' => 'A2 - Elementary',
                                'B1' => 'B1 - Intermediate',
                                'B2' => 'B2 - Upper Intermediate',
                                'C1' => 'C1 - Advanced',
                                'C2' => 'C2 - Proficient',
                            ])
                            ->hidden(fn ($get) => $get('is_native')),

                        Textarea::make('certificates')
                            ->label('Language Certificates')
                            ->rows(2)
                            ->columnSpanFull()
                            ->placeholder('e.g., TOEFL 110/120, IELTS 7.5, DELE B2')
                            ->helperText('List any language proficiency certificates.'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Language')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                IconColumn::make('is_native')
                    ->label('Native')
                    ->boolean(),

                TextColumn::make('listening')
                    ->label('Listening')
                    ->badge()
                    ->placeholder('N/A'),

                TextColumn::make('reading')
                    ->label('Reading')
                    ->badge()
                    ->placeholder('N/A'),

                TextColumn::make('spoken_interaction')
                    ->label('Speaking')
                    ->badge()
                    ->placeholder('N/A'),

                TextColumn::make('writing')
                    ->label('Writing')
                    ->badge()
                    ->placeholder('N/A'),

                TextColumn::make('certificates')
                    ->limit(30)
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->modalWidth('3xl')
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        ...self::form(\Filament\Schemas\Schema::make())->getComponents(),
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('3xl'),
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order')
            ->defaultSort('order', 'asc')
            ->paginated(false);
    }
}
