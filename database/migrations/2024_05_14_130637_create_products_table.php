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
        //$fillable = ['productid', 'price', 'stock', 'product_name', 'urlpicture', 'barcode', 'description'];
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->default('')->nullable();
            $table->string('product_id')->default('')->nullable();
            $table->string('product_name')->default('')->nullable();
            $table->text('urlpicture')->default('')->nullable();
            $table->string('barcode')->default('')->nullable();
            $table->longText('description')->default('')->nullable();
            $table->string('stock')->default('instock')->nullable();
            $table->double('price')->default(0)->nullable();
            $table->string('factory')->default('')->nullable();
            $table->string('color')->default('')->nullable();
            $table->string('size')->default('')->nullable();
            $table->string('ability')->default('')->nullable();
            $table->string('tag')->default('hiányzik')->nullable();
            $table->string('source')->default('')->nullable();
            $table->string('category')->default('')->nullable();
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
