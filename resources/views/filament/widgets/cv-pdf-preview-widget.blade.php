<x-filament-widgets::widget>
    <x-filament::section>
        <div class="h-[800px] w-full">
            @if($cvId)
                <iframe
                    src="{{ route('cv.show', $cvId) }}"
                    class="h-full w-full rounded-lg border-0"
                    title="CV PDF Preview"
                    wire:key="cv-preview-{{ $cvId }}"
                ></iframe>
            @else
                <div class="flex h-full items-center justify-center text-gray-500">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2">No CV selected for preview</p>
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
