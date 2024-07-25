<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Product;
use Filament\Pages\Page;
use App\Jobs\GenerateProductCsvJob;
use Illuminate\Support\Facades\Bus;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use App\Jobs\DatabaseProductDownloadFromBikeFunJob;
use App\Jobs\DatabaseProductDownloadFromBiketadeJob;

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
            new DatabaseProductDownloadFromBikeFunJob()
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

    protected function getViewData(): array
    {
        $csvContent = file_get_contents('https://xml.bikefun.hu/cikktorzs.xml');
        $xmlObject = simplexml_load_string($csvContent);
        $csvObject = str_getcsv($csvContent, ";", '"', "\r\n");
        $csvObject = str_getcsv($csvContent);
        dd($xmlObject);
        if (!$this->products) {
            $this->products = Product::all();
        }
        return [
            'products' => $this->products,
            'productsCount' => $this->products->count(),
        ];
    }
}
