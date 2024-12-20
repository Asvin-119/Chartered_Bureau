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
        Schema::create('hotel_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes')->onDelete('cascade');
            $table->foreignId('hotel_type_id')->constrained('hotel_types')->onDelete('cascade');
            $table->foreignId('hotel_location_id')->constrained('hotel_locations')->onDelete('cascade');
            $table->integer('hlquantity');
            $table->decimal('rate', 10, 2);
            $table->decimal('hlamount_rs', 15, 2);
            $table->decimal('hlamount_usd', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_reservations');
    }
};
