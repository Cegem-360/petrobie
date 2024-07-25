<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Collection;

class GenerateProductCsvJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct(public Collection $products)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $xmlContent = file_get_contents('https://biketrade97.hu/katalogus.xml');
        $xmlObject = simplexml_load_string($xmlContent);
        //$xmlObject = json_encode($xmlObject);
       // $xmlObject = json_decode($xmlObject, true);

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
                ]
            );
        }
        if(!$this->products) {
            return;
        }

        $csv = fopen('products.csv', 'w');
        $csvHeader = ['product_id', 'price', 'stock', 'product_name', 'urlpicture', 'barcode', 'description'];
        fputcsv($csv, $csvHeader);
        foreach ($this->products as $product) {
            fputcsv($csv, $product->toArray());
        }
    }
}
