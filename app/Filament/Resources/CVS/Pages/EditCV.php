<?php

namespace App\Filament\Resources\CVS\Pages;

use App\Filament\Resources\CVS\CVResource;
use App\Filament\Widgets\CVPdfPreviewWidget;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

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

    protected function getHeaderWidgets(): array
    {
        return [
            CVPdfPreviewWidget::make(['cvId' => $this->record->id]),
        ];
    }

    protected function getHeaderWidgetsColumns(): int | array
    {
        return [
            'md' => 2,
            'xl' => 5,
        ];
    }

    protected function afterSave(): void
    {
        $this->dispatch('cv-saved');
    }
}
