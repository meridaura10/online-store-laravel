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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('currency',3)->default('UAN');
            $table->uuidMorphs('payable');
            $table->decimal('amount',8,2);
            $table->string('status');
            $table->string('type');
            $table->string('system');
            $table->string('payment_page_url')->nullable();
            $table->timestamp('payment_expired_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
