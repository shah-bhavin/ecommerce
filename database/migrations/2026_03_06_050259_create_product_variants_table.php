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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            
            // Link to main product
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            
            $table->string('sku')->unique();
            $table->string('size')->nullable();
            $table->string('color')->nullable();

            $table->decimal('price_modifier', 12, 2)->default(0);
            $table->integer('stock_quantity')->default(0);

            $table->string('variant_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
