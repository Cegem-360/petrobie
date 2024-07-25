<x-filament-panels::page>
    <div class="">
        @empty (!$products)
            <div class="">
                @if ($productsCount > 0)
                    <x-filament::button wire:click="startGeneration" class="">Start Generation</x-filament::button>
                @else
                    <div class="p-4">
                        <p class="text-red-500">No products found</p>
                        <p class="text-red-500">Please create a products to generate</p>
                        <x-filament::button wire:click="startDatabaseUpFill" class="">Start Flooding</x-filament::button>
                    </div>
                @endif
            </div>
        @endempty
    </div>
</x-filament-panels::page>
