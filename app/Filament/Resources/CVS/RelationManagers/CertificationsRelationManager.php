<?php

namespace App\Filament\Resources\CVS\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CertificationsRelationManager extends RelationManager
{
    protected static string $relationship = 'certifications';

    protected static ?string $title = 'Certifications & Licenses';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->label('Certification Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., AWS Certified Solutions Architect'),

                        TextInput::make('issuing_organization')
                            ->label('Issuing Organization')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Amazon Web Services'),

                        DatePicker::make('issue_date')
                            ->label('Issue Date')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        DatePicker::make('expiry_date')
                            ->label('Expiry Date')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->helperText('Leave blank if it does not expire'),

                        TextInput::make('credential_id')
                            ->label('Credential ID')
                            ->maxLength(255),

                        TextInput::make('credential_url')
                            ->label('Credential URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://...'),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(2)
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
                    ->label('Certification')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('issuing_organization')
                    ->label('Organization')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('issue_date')
                    ->label('Issued')
                    ->date()
                    ->sortable(),

                TextColumn::make('expiry_date')
                    ->label('Expires')
                    ->date()
                    ->sortable()
                    ->placeholder('No expiry'),

                TextColumn::make('credential_id')
                    ->label('ID')
                    ->toggleable(),

                TextColumn::make('credential_url')
                    ->label('URL')
                    ->url(fn ($record) => $record->credential_url)
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
