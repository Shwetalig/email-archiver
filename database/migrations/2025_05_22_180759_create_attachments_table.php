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
        Schema::create('attachments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('email_id')->constrained()->onDelete('cascade');
    $table->string('filename');
    $table->string('mime_type');
    $table->string('drive_file_id');
    $table->string('drive_file_link');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
