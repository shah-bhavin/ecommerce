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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        
            // Address Details
            $table->string('fullname'); // Name of receiver
            $table->string('phone');
            $table->string('house_no'); // Flat, House no, Building
            $table->string('area');     // Street, Sector, Village
            $table->string('landmark')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('pincode', 6); // Standard 6-digit Indian PIN
            
            // Type & Status
            $table->enum('type', ['home', 'office', 'other'])->default('home');
            $table->boolean('is_default')->default(false); // To mark primary address
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
