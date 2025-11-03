<?php

namespace App\Filament\Resources\CVS\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CVSTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('CV Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('last_name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('is_public')
                    ->label('Public')
                    ->boolean()
                    ->sortable()
                    ->icon(fn ($state) => $state ? Heroicon::OutlinedGlobeAlt : null)
                    ->color(fn ($state) => $state ? 'success' : 'gray'),

                TextColumn::make('public_views_count')
                    ->label('Views')
                    ->badge()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('info'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('city')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('country')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('nationality')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('linkedin_url')
                    ->label('LinkedIn')
                    ->url(fn ($record) => $record->linkedin_url)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('website_url')
                    ->label('Website')
                    ->url(fn ($record) => $record->website_url)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('view')
                    ->label('Preview')
                    ->icon(Heroicon::OutlinedEye)
                    ->url(fn ($record) => route('cv.show', $record))
                    ->openUrlInNewTab()
                    ->color('info'),
                Action::make('download')
                    ->label('Download PDF')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->url(fn ($record) => route('cv.pdf', $record))
                    ->openUrlInNewTab()
                    ->color('success'),
                Action::make('publish')
                    ->label(fn ($record) => $record->is_public ? 'Unpublish' : 'Publish')
                    ->icon(fn ($record) => $record->is_public ? Heroicon::OutlinedEyeSlash : Heroicon::OutlinedGlobeAlt)
                    ->color(fn ($record) => $record->is_public ? 'gray' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn ($record) => $record->is_public ? 'Unpublish CV?' : 'Publish CV?')
                    ->modalDescription(fn ($record) => $record->is_public
                        ? 'This will make the CV private. The public link will no longer be accessible.'
                        : 'This will make the CV publicly accessible via a unique link.')
                    ->action(function ($record) {
                        $record->update(['is_public' => ! $record->is_public]);
                    })
                    ->successNotificationTitle(fn ($record) => $record->is_public ? 'CV published successfully!' : 'CV unpublished successfully.'),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
