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
        Schema::create('add_on_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product')->nullable()->constrained('products')->onDelete('set null');
            $table->string('name');
            $table->string('price')->nullable()->default(0);
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_on_features');
    }
};
