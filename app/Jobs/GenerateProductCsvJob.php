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
        $csvHeader = ['product_id', 'price', 'stock', 'product_name', 'urlpicture', 'barcode', 'description', 'sku','factory','color','size','ability','tag'];
        fputcsv($csv, $csvHeader);
        foreach ($this->products as $product) {
            fputcsv($csv, $product->toArray());
        }
    }
}
