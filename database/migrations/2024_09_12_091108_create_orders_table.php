<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{

    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('sub_total', 10, 2)->default(0.00); 
            $table->unsignedBigInteger('shipping_id')->nullable();
            $table->string('coupon')->nullable();
            $table->string('avatar')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0.00); 
            $table->integer('quantity')->default(0); 
            $table->enum('payment_method', ['stripe', 'paypal']);
            $table->enum('payment_status', ['paid', 'unpaid' , 'cancelled'])->default('unpaid');
            $table->enum('status', ['pending payment', 'processing', 'delivered', 'cancelled'])->default('pending payment');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('country');
            $table->string('city');
            $table->string('post_code');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
