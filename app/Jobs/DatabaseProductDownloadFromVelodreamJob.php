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
    0 => "BR-X90"
    1 => "250 03 650 52"
    2 => "4055149337308"
    3 => "1,27"
    4 => "8714"
    5 => "2950,0000"
    6 => "3746,500000"
    7 => "4100,0000"
    8 => "0"
    9 => "http://b2b.bike-parts.de/b2bdocs/BP/txt/c450a4221fcc7dab7dfa51958c162202.HTM"
    10 => "http://b2b.bike-parts.de/b2bdocs/BP/images/8e7e93f826237de4123139492073ca78.JPG"
    11 => "XLC Bremszugkit BR-X90"
    12 => "1000/1350mm, Ø 1,5mm, inkl 2 Nippel"
    13 => ""
    14 => ""
    15 => "False"
    16 => "False"
    17 => "Bowden fék MTB BR-X18"
        */
        //open csv file from velodream folder at  storage/app/velodream/velodream.csv and save to database
        $content = file_get_contents(storage_path('app/velodream/velodream.csv'));
        $csvContent = str_getcsv($content, ";");
        $csvContent = array_chunk($csvContent, 18);
        dd($csvContent);
        array_shift($csvContent);

        foreach ($csvContent as $product) {
            if(!isset($product[0]) || $product[0] == ""){
                continue;
            }
            $prod = Product::firstOrCreate([
                'product_id' => $product[0],
            ]);

            $prod->update(
                [
                    'product_id' => $product[0],
                    'price' => floatval(str_replace(',', '.', $product[7])),
                    'stock' => $product[8],
                    'product_name' => $product[17],
                    'urlpicture' => $product[10],
                    'barcode' =>    $product[2],
                    'description' => $product[15],
                    'sku' => $product[1],
                ]
            );
        }
    }
}
