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

        if(!$this->products) {
            return;
        }

        $csv = fopen('products.csv', 'w');
        $csvHeader = ['product_id', 'price', 'stock', 'product_name', 'urlpicture', 'barcode', 'description', 'sku','factory','color','size','ability','tag','source','category'];
        fputcsv($csv, $csvHeader);
        foreach ($this->products as $product) {
            $csv_product = [
                'product_id' => $product->product_id,
                'price' => $product->price,
                'stock' => $product->stock,
                'product_name' => $product->product_name,
                'urlpicture' => $product->urlpicture,
                'barcode' => $product->barcode,
                'description' => $product->description,
                'sku' => $product->sku,
                'factory' => $product->factory,
                'color' => $product->color,
                'size' => $product->size,
                'ability' => $product->ability,
                'tag' => $product->tag,
                'source' => $product->source,
                'category' => $product->category,
            ];
            fputcsv($csv, $csv_product);
        }
    }
}
