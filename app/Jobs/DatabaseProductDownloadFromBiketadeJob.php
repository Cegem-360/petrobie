<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DatabaseProductDownloadFromBiketadeJob implements ShouldQueue
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
        $xmlContent = file_get_contents('https://biketrade97.hu/katalogus.xml');
        $xmlObject = simplexml_load_string($xmlContent);

        foreach ($xmlObject->product as $product) {
            $prod = Product::firstOrCreate([
                'product_id' => $product->productid,
            ]);

            $prod->update(
                [
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'product_name' => $product->productname,
                    'urlpicture' => $product->urlpicture,
                    'barcode' =>    $product->barcode,
                    'description' => $product->desc,
                    'sku' => $product->barcode,
                    'source' => 'biketade',
                    'tag'=>'Biketrade',
                    'category'=>'Új termékek',
                ]
            );
        }
    }
}
