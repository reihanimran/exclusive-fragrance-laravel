<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migration: create_orders_table.php
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('shipping_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamp('order_date')->useCurrent();
            $table->enum('order_status', ['Pending', 'Cancelled', 'Completed', 'Processing']);
            $table->decimal('total_sale_amount', 12, 2);
            $table->decimal('total_order_amount', 12, 2);
            $table->timestamps(); // Matches your created_at in screenshot
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
