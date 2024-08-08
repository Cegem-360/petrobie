<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Jobs\DatabaseProductDownloadFromBikeFunJob;
use App\Jobs\DatabaseProductDownloadFromBiketadeJob;
use App\Jobs\DatabaseProductDownloadFromVelodreamJob;
use App\Jobs\GenerateProductCsvJob;
use App\Models\Product;
use Artisan;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Http;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Bus;

final class ImportManagementPage extends Page
{
    public Collection $products;

    public $velodream;
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
            new DatabaseProductDownloadFromBikeFunJob(),
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
            ->name('DownloadBikeTradeBikeFunVelodream')
            ->dispatch();

        $this->dispatch('$refresh');

        $this->startGeneration();
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

    public function downloadCsv(): void
    {
        $this->startGeneration();
        Notification::make()
            ->title('Download started')
            ->body('The download will start in a few seconds.')
            ->success()
            ->send();
        $this->dispatch('$refresh');
    }

    public function resetDatabase(): void
    {
        //only refresh product table
        Product::truncate();

        //Artisan::call('migrate:refresh', ['--seed' => true]);
    }

    public function saveFile(): void
    {
        Notification::make()
            ->title('Download started')
            ->body('The download will start in a few seconds.')
            ->warning()
            ->send();
        dd($this->velodream);
        $this->velodream->storeAs(path: 'velodream', name: 'velodream.csv');

        Notification::make()
            ->title('Velodream Download finised')
            ->body('The download finished.')
            ->success()
            ->send();
        //$this->dispatch('$refresh');

        $this->startDatabaseUpFill();

        Notification::make()
        ->title('Completed the generation')
        ->body('The downloads finished.')
        ->success()
        ->send();
        //$this->dispatch('$refresh');
        //TODO: https://petrobike.hu/ import triger
        //Http::get('https://petrobike.hu/import');
    }

    protected function getViewData(): array
    {
        if ( ! $this->products) {
            $this->products = Product::all();
        }
        return [
            'products' => $this->products,
            'productsCount' => $this->products->count(),
        ];
    }
}
