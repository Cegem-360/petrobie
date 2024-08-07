<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Artisan;
use App\Models\Product;
use Filament\Pages\Page;
use App\Jobs\GenerateProductCsvJob;
use Illuminate\Support\Facades\Bus;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use App\Jobs\DatabaseProductDownloadFromBikeFunJob;
use App\Jobs\DatabaseProductDownloadFromBiketadeJob;
use App\Jobs\DatabaseProductDownloadFromVelodreamJob;

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
            //new DatabaseProductDownloadFromBiketadeJob(),
            //new DatabaseProductDownloadFromBikeFunJob(),
            new DatabaseProductDownloadFromVelodreamJob(),
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
            new GenerateProductCsvJob($this->products)
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

    public function downloadCsv(): void
    {
        $this->startGeneration();
        $this->dispatchBrowser(
            fn () => Notification::make()
                ->title('Download started')
                ->message('The download will start in a few seconds.')
                ->success()
                ->send()
        );
    }

    public function resetDatabase()
    {
        Artisan::call('migrate:refresh', ['--seed' => true]);
    }

    protected function getViewData(): array
    {
        if (!$this->products) {
            $this->products = Product::all();
        }
        return [
            'products' => $this->products,
            'productsCount' => $this->products->count(),
        ];
    }
}
