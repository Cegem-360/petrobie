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

    public function exportBikefun()
    {
        // Export logic here

        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://xml.bikefun.hu/cikktorzs.csv');
        $csvContent = $response->getBody()->getContents();

        // return $csvContent as a download
        Storage::putFile('cikktorzs.csv', $csvContent);

        $user = auth()->user;
        Notification::make()->title('Sikeres exportálás!')
            ->body(' sikerült exportálni a BikeFun-t.')
            ->sendToDatabase($user);
        ;
        return Storage::download('cikktorzs.csv');
    }


}
