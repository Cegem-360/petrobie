<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DatabaseProductDownloadFromBikeFunJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
