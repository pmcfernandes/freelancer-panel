<x-filament::page>
    {{-- Filters at the top --}}
    <div class="mb-4">
        {{ $this->filtersForm }}
    </div>

    {{-- Dashboard widgets --}}
    {{ $this->headerWidgets }}
</x-filament::page>
