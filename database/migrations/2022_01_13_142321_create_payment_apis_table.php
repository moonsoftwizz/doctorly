<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_apis', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('gateway_type')->comment('1=>Razorpay','2=>Stripe');
            $table->text('key');
            $table->text('secret');
            $table->integer('is_deleted')->default(0)->comment("0=>Active, 1=>Deleted");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_apis');
    }
}
