<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Jobs\DatabaseProductDownloadFromBiketadeJob;
use App\Jobs\GenerateProductCsvJob;
use App\Models\Product;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Bus;

final class ImportManagementPage extends Page
{
    public Collection $products;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Imortálás';

    protected static ?string $title = 'Product Import Management » Start & Download products';

    protected static string $view = 'filament.pages.import-management-page';

    protected static ?int $navigationSort = 2;

    public function mount(): void
    {
        $this->products = Product::all();
    }

    public function startDatabaseUpFill(): void
    {

        Bus::batch([
            new DatabaseProductDownloadFromBiketadeJob(),
        ])->then(function (): void {
            Notification::make()
                ->title('Download finished')
                ->success()
                ->send();
        })->catch(function (): void {
            Notification::make()
                ->title('Download failed')
                ->danger()
                ->send();
        })
            ->name('DownloadBikeTradeXml')
            ->dispatch();

        $this->dispatch('$refresh');

    }

    public function startGeneration(): void
    {
        Bus::batch([
            new GenerateProductCsvJob($this->products),
        ])->then(function (): void {
            Notification::make()
                ->title('GenerateProductCsvJob finished')
                ->success()
                ->send();
        })->catch(function (): void {
            Notification::make()
                ->title('GenerateProductCsvJob failed')
                ->danger()
                ->send();
        })
            ->name('GenerateProductCsvJob')
            ->dispatch();

        $this->dispatch('$refresh');

    }

    protected function getViewData(): array
    {
        if (!$this->products) {
            $this->products = Product::all();
        }
        /** @var Panel $panel */
        $panel = Product::all();
        return [
            'productsCount' => $panel->count(),
        ];
    }
}
