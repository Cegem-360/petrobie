<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Jobs\ExportBikefunProductsForNemetKerekpar;
use Bus;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;

final class ExportBikeFunPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Exportálás';

    protected static ?string $title = 'Exportálás » BikeFun németkerékpár részére';

    protected static string $view = 'filament.pages.export-bikefun-page';

    protected static ?int $navigationSort = 2;

    public function exportBikefun(): void
    {
        // Export logic here
        $user = auth()->user();

        Bus::batch([
            new ExportBikefunProductsForNemetKerekpar(),
        ])
            ->then(function (): void {
                Notification::make()
                    ->title('Can finished')
                    ->body(' sikerült exportálni a BikeFun-t.')
                    ->send();
            })
            ->name('DownloadCsvJob')
            ->dispatch();


        // return Storage::download('cikktorzs.csv');
    }
}
