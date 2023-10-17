<?php

use App\Models\Property;
use App\Models\PropertyValue;
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
        Schema::create('property_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Property::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('property_value_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PropertyValue::class)->constrained()->cascadeOnDelete();
            $table->string('value');
            $table->string('locale');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_value_translations');
        Schema::dropIfExists('property_values');
    }
};
