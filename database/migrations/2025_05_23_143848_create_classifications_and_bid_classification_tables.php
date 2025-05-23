<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('classifications', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('type')->nullable(); // e.g., project_type, value_range, contractor
        $table->timestamps();
    });
    Schema::create('bid_classification', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bid_id')->constrained()->onDelete('cascade');
        $table->foreignId('classification_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classifications_and_bid_classification_tables');
    }
};
