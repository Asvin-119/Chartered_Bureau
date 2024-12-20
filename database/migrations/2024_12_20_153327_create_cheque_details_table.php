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
        Schema::create('cheque_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rv_code');
            $table->string('cheque_no');
            $table->date('cheque_date');
            $table->decimal('amount', 10, 2);
            $table->string('bank');
            $table->timestamps();

            $table->foreign('rv_code')->references('id')->on('voucher_codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheque_details');
    }
};
