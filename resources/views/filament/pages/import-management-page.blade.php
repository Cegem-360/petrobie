<x-filament-panels::page>

<x-filament::section>
    <x-slot name="heading">
        Import Management
    </x-slot>

    <form wire:submit="saveFile" enctype="multipart/form-data">
        @csrf
        <input type="file" wire:model="velodream">

        @error('velodream') <span class="error">{{ $message }}</span> @enderror

        <x-filament::button class="">upload</x-filament::button>
    </form>
</x-filament::section>


    <x-slot name="title">Import Management</x-slot>
    <x-slot name="description">Import Management</x-slot>
    <x-slot name="actions">
        <x-filament::button wire:click="startGeneration" class="">Start Generation</x-filament::button>
        <x-filament::button wire:click="startDatabaseUpFill" class="">Start Flooding</x-filament::button>

        <x-filament::button wire:click="downloadCsv" class="">downloadCsv</x-filament::button>
    </x-slot>
    <div class="p-4">
        <x-filament::button wire:click="resetDatabase" class="">Reset</x-filament::button>
    </div>


    <div class="">
        @if ($productsCount > 0)
            <div class="p-4">
                <p class="text-red-500">{{ $productsCount }} products found</p>
                <p class="text-red-500">Please push the button to start generate csv file</p>
                <x-filament::button wire:click="startGeneration" class="">Start Generation</x-filament::button>
            </div>
        @endif
        <div class="p-4">
            @if ($productsCount > 0)
                <p class="text-red-500">{{ $productsCount }} products found</p>
            @else
            <p class="text-red-500">No products found</p>
            <p class="text-red-500">Please create a products to generate</p>
            @endif
            <x-filament::button wire:click="startDatabaseUpFill" class="">Start Flooding</x-filament::button>
        </div>


    </div>
</x-filament-panels::page>
