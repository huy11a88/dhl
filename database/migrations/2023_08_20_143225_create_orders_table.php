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
            $table->foreignId('user_id')->constrained();
            $table->foreignId('shipping_staff_id')->nullable()->constrained('users');
            $table->string('order_number')->unique();
            $table->string('recipient_address');
            $table->string('shipping_address');
            $table->dateTime('shipping_date');
            $table->dateTime('expected_delivery_date');
            $table->tinyInteger('status');
            $table->tinyInteger('rating');
            $table->timestamps();
            $table->softDeletes();
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
