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
        Schema::create('ticket_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes')->onDelete('cascade'); // Foreign key to quotes
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade'); // Foreign key to tickets
            $table->string('details');
            $table->integer('quantity')->default(1);
            $table->decimal('rate', 10, 2)->default(0.00);
            $table->decimal('amount_lkr', 10, 2)->default(0.00);
            $table->decimal('amount_usd', 10, 2)->default(0.00);
            $table->text('airline_details')->nullable();
            $table->text('booking_summary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_reservations');
    }
};
