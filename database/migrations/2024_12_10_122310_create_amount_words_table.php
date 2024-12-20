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
        Schema::create('amount_words', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rv_code'); // Ensure it's an unsigned big integer
            $table->foreign('rv_code')->references('id')->on('voucher_codes')->onDelete('cascade'); // Correct the table and column reference
            $table->string('amountword_rs');
            $table->string('amountword_usd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amount_words');
    }
};
