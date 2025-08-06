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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('header_image')->nullable()->default(null);
            $table->string('primary_image')->nullable()->default(null);
            $table->string('secondary_image')->nullable()->default(null);
            $table->string('header_extra')->nullable()->default(null);
            $table->string('header_title')->nullable()->default(null);
            $table->text('header_text')->nullable()->default(null);
            $table->string('primary_title')->nullable()->default(null);
            $table->text('primary_text')->nullable()->default(null);
            $table->string('secondary_title')->nullable()->default(null);
            $table->text('secondary_text')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
