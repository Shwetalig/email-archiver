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
    Schema::table('attachments', function (Blueprint $table) {
        $table->string('file_name')->nullable();
        $table->string('drive_file_id')->nullable();
        $table->string('drive_file_link')->nullable();
    });
}

public function down()
{
    Schema::table('attachments', function (Blueprint $table) {
        $table->dropColumn(['file_name', 'drive_file_id', 'drive_file_link']);
    });
}

};
