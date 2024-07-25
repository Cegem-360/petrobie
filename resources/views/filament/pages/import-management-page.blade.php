<x-filament-panels::page>
    <div class="">
        @if (!$products)
            <div class="">
                @if ($productsCount > 0)
                    <x-filament::button wire:click="startGeneration" class="">Start Generation</x-filament::button>
                @else
                    <div class="p-4">
                        <p class="text-red-500">No products found</p>
                        <p class="text-red-500">Please create a products to generate</p>
                    </div>
                @endif
            </div>
        @else
            <div class="">
                @if ($productsCount > 0)
                    <x-filament::button wire:click="startGeneration" class="">Start Generation</x-filament::button>
                @else
                    <div class="p-4">
                        <p class="text-red-500">No products found</p>
                        <p class="text-red-500">Please create a products to generate</p>
                    </div>
                @endif
            </div>

        @endif
    </div>
</x-filament-panels::page>
