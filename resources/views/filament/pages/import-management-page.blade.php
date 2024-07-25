<x-filament-panels::page>
    <div class="">
            @if ($productsCount > 0)
            <div class="p-4">
                <p class="text-red-500">{{ $productsCount }} products found</p>
                <p class="text-red-500">Please push the button to start generate csv file</p>
                <x-filament::button wire:click="startGeneration" class="">Start Generation</x-filament::button>
            </div>

            @else
                <div class="p-4">
                    <p class="text-red-500">No products found</p>
                    <p class="text-red-500">Please create a products to generate</p>
                    <x-filament::button wire:click="startDatabaseUpFill" class="">Start Flooding</x-filament::button>
                </div>
            @endif
    </div>
</x-filament-panels::page>
