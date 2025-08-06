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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('product_size_id')->nullable()->constrained('product_sizes')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('add_on_added')->default(0)->nullable();
            $table->string('add_on_size')->nullable();
            $table->integer('add_on_price')->default(0)->nullable();
            $table->integer('order_amount');
            $table->integer('price');
            $table->integer('total_price');
            $table->integer('is_active');
            $table->integer('is_paid')->default(0)->nullable();
            $table->integer('is_shipped');
            $table->integer('is_delivered');
            $table->integer('is_completed')->nullable();
            $table->string('recieving_address')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('tracking_id')->nullable();
            $table->string('service')->nullable();
            $table->integer('is_deleted')->default(0);
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
