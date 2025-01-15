<?php

declare(strict_types=1);

namespace App\Filament\Pages;

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

    public function mount(): void {}

    public function exportBikefun(): void
    {
        // Export logic here

        $csvContent = file_get_contents('https://xml.bikefun.hu/cikktorzs.csv');

        // return $csvContent as a download
        Storage::putFile('cikktorzs.csv', $csvContent);

        $user = auth()->user;
        Notification::make()->title('Sikeres exportálás!')
            ->body(Storage::url('cikktorzs.csv') . ' sikerült exportálni a BikeFun-nak.')
            ->sendToDatabase($user);
        ;
    }


}
