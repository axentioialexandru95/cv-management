<div class="space-y-6">
    {{-- Public Link Section --}}
    @if($record->is_public && $record->public_slug)
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-globe-alt" class="h-5 w-5 text-success-500" />
                    Public Link
                </div>
            </x-slot>

            <x-slot name="description">
                This CV is publicly accessible
            </x-slot>

            <div class="space-y-4">
                {{-- URL Display with Copy --}}
                <div class="flex items-center gap-2">
                    <input
                        type="text"
                        value="{{ $record->public_url }}"
                        readonly
                        class="flex-1 rounded-lg border-gray-300 bg-gray-50 text-sm dark:border-gray-600 dark:bg-gray-900"
                        x-data
                        x-ref="publicUrl"
                    />
                    <button
                        type="button"
                        class="rounded-lg bg-primary-600 px-3 py-2 text-sm font-medium text-white hover:bg-primary-700"
                        x-on:click="
                            navigator.clipboard.writeText($refs.publicUrl.value);
                            $tooltip('Link copied to clipboard!', { timeout: 2000 });
                        "
                    >
                        <x-filament::icon icon="heroicon-o-clipboard" class="h-4 w-4" />
                    </button>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-2">
                    <a
                        href="{{ $record->public_url }}"
                        target="_blank"
                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        <x-filament::icon icon="heroicon-o-arrow-top-right-on-square" class="h-4 w-4" />
                        Open
                    </a>
                    <a
                        href="{{ route('cv.public.pdf', ['slug' => $record->public_slug]) }}"
                        target="_blank"
                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        <x-filament::icon icon="heroicon-o-arrow-down-tray" class="h-4 w-4" />
                        PDF
                    </a>
                </div>

                {{-- Stats --}}
                <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-900">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Total Views</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">
                            {{ number_format($record->public_views_count) }}
                        </span>
                    </div>
                    @if($record->last_viewed_at)
                        <div class="mt-2 flex items-center justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Last Viewed</span>
                            <span class="text-gray-900 dark:text-gray-100">
                                {{ $record->last_viewed_at->diffForHumans() }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </x-filament::section>
    @endif

    {{-- PDF Preview Section --}}
    <div class="h-[800px] w-full" wire:key="cv-preview-container">
        <iframe
            src="{{ route('cv.show', $record->id) }}"
            class="h-full w-full rounded-lg border-0"
            title="CV PDF Preview"
            wire:key="cv-preview-{{ $record->id }}"
            x-data="{ timestamp: Date.now() }"
            x-on:cv-saved.window="timestamp = Date.now(); $el.src = $el.src.split('?')[0] + '?t=' + timestamp"
        ></iframe>
    </div>
</div>
