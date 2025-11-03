<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CVS\CVResource;
use App\Models\CV;
use Filament\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentCVs extends TableWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Recent CVs';

    protected static ?string $description = 'Latest CV updates';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                CV::query()
                    ->latest('updated_at')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->url(fn (CV $record): string => CVResource::getUrl('edit', ['record' => $record]))
                    ->color('primary'),

                TextColumn::make('owner_name')
                    ->label('Owner')
                    ->getStateUsing(fn (CV $record): string => trim("{$record->first_name} {$record->last_name}"))
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderBy('first_name', $direction);
                    }),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->description(fn (CV $record): string => $record->updated_at->format('M d, Y')),
            ])
            ->defaultSort('updated_at', 'desc')
            ->paginated(false);
    }
}
