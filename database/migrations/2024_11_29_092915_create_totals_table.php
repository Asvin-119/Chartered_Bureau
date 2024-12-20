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
        Schema::create('totals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->onDelete('cascade');
            $table->text('airline_details')->nullable(); // Stores airline details
            $table->text('booking_summary')->nullable(); // Stores booking summary
            $table->decimal('lkr_total', 10, 2)->default(0); // Stores total amount
            $table->decimal('usd_total', 10, 2)->default(0); // Stores total amount
            $table->decimal('tax', 5, 2)->default(0); // Stores tax percentage
            $table->decimal('lkr_grand_total', 10, 2)->default(0); // Stores grand total amount
            $table->decimal('usd_grand_total', 10, 2)->default(0); // Stores grand total amount
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('totals');
    }
};
