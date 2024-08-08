<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DatabaseProductDownloadFromVelodreamJob implements ShouldQueue
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
        /*
        [
    0 =>"Name"
    1 => "ID"
    2 => "SKU"
    3 => "EAN"
    4 => "AFA"
    5 => "VTSZ"
    6 => "Netto"
    7 => "Brutto"
    8 => "Ajfogy"
    9 => "Keszlet"
    10 => "InfoURL"
    11 => "pictURL"
    12 => "Desc1"
    13 => "Desc2"
    14 => "Leiras1"
    15 => "Leiras2"
    16 => "Akcios"
    17 => Kifuto
    ]
        */
        //open csv file from velodream folder at  storage/app/velodream/velodream.csv and save to database
        $content = file_get_contents(storage_path('app/velodream/velodream.csv'));
        $csvContent = str_getcsv($content, ";");
        $csvContent = array_chunk($csvContent, 18);
        array_shift($csvContent);

        foreach ($csvContent as $product) {
            if(!isset($product[0]) || $product[0] == ""){
                continue;
            }
            $prod = Product::firstOrCreate([
                'product_id' => $product[1],
            ]);

            $prod->update(
                [
                    'price' => $product[8],
                    'stock' => $product[9],
                    'product_name' => $product[0],
                    'urlpicture' => $product[11],
                    'barcode' =>    $product[3],
                    'description' => $product[15],
                    'sku' => $product[2],
                ]
            );
        }
    }
}
