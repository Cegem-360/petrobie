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

    public function exportBikefun()
    {
        // Export logic here
        $user = auth()->user;

        Bus::dispatch(new ExportBikefunProductsForNemetKerekpar())->then(function () use ($user): void {
            Notification::make()
                ->title('Can finished')
                ->body(' sikerült exportálni a BikeFun-t.')
                ->sendToDatabase($user);
        });

        return Storage::download('cikktorzs.csv');
    }
}
