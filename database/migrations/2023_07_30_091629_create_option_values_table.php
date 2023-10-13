<?php

use App\Models\Option;
use App\Models\OptionValue;
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
        Schema::create('option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Option::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('option_value_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OptionValue::class)->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('option_value_translations');
        Schema::dropIfExists('option_values');
    }
};
