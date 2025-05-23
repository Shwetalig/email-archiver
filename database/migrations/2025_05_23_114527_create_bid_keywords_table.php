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
        Schema::create('bid_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('pattern');
            $table->enum('type', ['initial', 'follow-up', 'contract', 'other']);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bid_keywords');
    }
};
