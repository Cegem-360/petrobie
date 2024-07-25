<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $fillable = ['productid', 'price', 'stock', 'product_name', 'urlpicture', 'barcode', 'description'];
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->default('hiányzik')->nullable();
            $table->string('product_name')->default('hiányzik')->nullable();
            $table->text('urlpicture')->default('hiányzik')->nullable();
            $table->string('barcode')->default('hiányzik')->nullable();
            $table->longText('description')->default('hiányzik')->nullable();
            $table->string('stock')->default('instock')->nullable();
            $table->double('price')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
