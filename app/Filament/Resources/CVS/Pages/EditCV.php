<?php

namespace App\Filament\Resources\CVS\Pages;

use App\Filament\Resources\CVS\CVResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

class EditCV extends EditRecord
{
    protected static string $resource = CVResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make([
                    'default' => 1,
                    'xl' => 5,
                ])
                    ->schema([
                        // Left column: Form + Actions (60% width = 3/5 columns)
                        Grid::make(1)
                            ->schema([
                                $this->getFormContentComponent(),
                            ])
                            ->columnSpan([
                                'xl' => 3,
                            ]),

                        // Right column: Custom preview content (40% width = 2/5 columns)
                        View::make('filament.resources.cvs.pages.preview-sidebar')
                            ->viewData([
                                'record' => $this->record,
                            ])
                            ->columnSpan([
                                'xl' => 2,
                            ]),
                    ]),

                // Relation managers below (if any)
                $this->getRelationManagersContentComponent(),
            ]);
    }

    protected function afterSave(): void
    {
        $this->dispatch('cv-saved');
    }
}
