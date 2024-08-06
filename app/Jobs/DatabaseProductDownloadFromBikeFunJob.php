<?php

namespace App\Jobs;

use App\Models\Product;
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
    /*
    0 => "Code"
    1 => "Name"
    2 => "Price"
    3 => "RetailerDiscountPrice"
    4 => "VAT"
    5 => "Comment"
    6 => "LongName"
    7 => "UnitVolume"
    8 => "OrderUnit"
    9 => "txtLeaderItemCode"
    10 => "DeliveryDate1"
    11 => "DeliveryDate2"
    12 => "DeliveryDate3"
    13 => "DeliveryDate4"
    14 => "DeliveryDate5"
    15 => "DeliveryFree1"
    16 => "DeliveryFree2"
    17 => "DeliveryFree3"
    18 => "DeliveryFree4"
    19 => "DeliveryFree5"
    20 => "NameHU"
    21 => "DescriptionHU"
    22 => "NameRo"
    23 => "DescriptionRO"
    24 => "param0HU"
    25 => "param0RO"
    26 => "param1HU"
    27 => "param1RO"
    28 => "param2HU"
    29 => "param2RO"
    30 => "param3HU"
    31 => "param3RO"
    32 => "param4HU"
    33 => "param4RO"
    34 => "param5HU"
    35 => "param5RO"
    36 => "param6HU"
    37 => "param6RO"
    38 => "param7HU"
    39 => "param7RO"
    40 => "param8HU"
    41 => "param8RO"
    42 => "param9HU"
    43 => "param9RO"
    44 => "Status"
    45 => "FogyAr"
    46 => "AkciosFogyAr"
    47 => "FogyArRO"
    48 => "AkciosFogyArRO"
    49 => "Vonalkod"
    50 => "MainImage"
    51 => "Image weight0"
    52 => "Image weight1"
    53 => "Image weight2"
    54 => "Image weight3"
    55 => "Image weight4"
    56 => "Image weight5"
    57 => "Image weight6"
    58 => "Image weight7"
    59 => "Image weight8"
    60 => "Image weight9"
    61 => "webcat"
    */

    $csvContent = file_get_contents('https://xml.bikefun.hu/cikktorzs.csv');
    $csvContent = str_getcsv($csvContent, ";");
    $csvContent = array_chunk($csvContent, 62);
    array_shift($csvContent);

    foreach ($csvContent as $product) {
        $prod = Product::firstOrCreate([
            'product_id' => $product[0],
        ]);

        $prod->update(
            [
                'price' => $product[2],
                'stock' => $product[45],
                'product_name' => $product[1],
                'urlpicture' => $product[50],
                'barcode' =>    $product[49],
                'description' => $product[21],
            ]
        );
    }

    dd($csvContent);
        //dd($csvContent['Product'][1]);
    }
}
