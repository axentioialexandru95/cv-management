<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class CVPdfPreviewWidget extends Widget
{
    protected string $view = 'filament.widgets.cv-pdf-preview-widget';

    protected static bool $isLazy = false;

    protected static bool $isDiscovered = false;

    public ?int $cvId = null;

    #[On('cv-saved')]
    public function refreshPreview(): void
    {
        // This will trigger a re-render of the widget
        $this->dispatch('$refresh');
    }

    public function mount(?int $cvId = null): void
    {
        $this->cvId = $cvId;
    }
}
