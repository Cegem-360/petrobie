<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

final class ExportBikefunProductsForNemetKerekpar implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct() {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://xml.bikefun.hu/cikktorzs.csv');
        $csvContent = $response->getBody()->getContents();

        // return $csvContent as a download
        Storage::putFile('cikktorzs.csv', $csvContent);


    }
}
