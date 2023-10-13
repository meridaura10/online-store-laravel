<?php

use App\Models\Property;
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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->references('id')->on('properties')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('property_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignIdFor(Property::class)->constrained()->cascadeOnDelete();
            $table->string('locale');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_translations');
        Schema::dropIfExists('properties');
    }
};
