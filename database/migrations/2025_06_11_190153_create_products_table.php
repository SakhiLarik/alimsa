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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->foreignId('category')->nullable()->constrained('product_categories')->onDelete('set null');
            $table->foreignId('sub_category')->nullable()->constrained('sub_categories')->onDelete('set null');
            $table->integer('is_perfume')->default(0);
            $table->string('name');
            $table->string('size');
            $table->string('symbol')->nullable();
            $table->integer('price')->default(0);
            $table->string('color')->nullable();
            $table->string('image');
            $table->string('febric')->nullable();
            $table->string('design')->nullable();
            $table->string('season')->nullable();
            $table->string('occasion')->nullable();
            $table->string('gender')->nullable();
            $table->string('availability');
            $table->string('outfit')->nullable();
            $table->text('description');
            $table->text('remarks');
            $table->integer('is_deleted')->default(0);
            $table->date('deleted_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
