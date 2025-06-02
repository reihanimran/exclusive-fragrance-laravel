<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Custom primary key name
            $table->string('product_name');
            $table->string('brand');
            $table->string('fragrance_type');
            $table->decimal('original_price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock_quantity');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->text('product_desc');
            $table->string('size');
            $table->boolean('Bestseller')->default(false);
            $table->enum('gender', ['M', 'F', 'U'])->default('U'); // M=Male, F=Female, U=Unisex
            $table->timestamps(); // Will create created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
