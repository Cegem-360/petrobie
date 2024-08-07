<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'price', 'stock', 'product_name', 'urlpicture', 'barcode', 'description', 'sku','factory','color','size','ability','tag'];
}
