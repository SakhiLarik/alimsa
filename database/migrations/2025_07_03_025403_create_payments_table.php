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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->integer('payable');
            $table->integer('paid')->default(0);
            $table->string('payment_method');
            $table->string('account')->nullable();
            $table->string('account_title')->nullable();
            $table->string('account_number')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('screenshot')->nullable();
            $table->integer('payment_successfull')->nullable();
            $table->integer('order_completed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
