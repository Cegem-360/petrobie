<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DatabaseProductDownloadFromBikeFunJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $csvContent = file_get_contents('https://xml.bikefun.hu/cikktorzs.xml');
        $csvObject = str_getcsv($csvContent, ";", '"', "\r\n");
        $csvObject = str_getcsv($csvContent);
        dd($csvContent['Product'][0]);
        dd($csvContent['Product'][1]);
    }
}
