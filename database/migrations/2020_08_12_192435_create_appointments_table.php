<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_for');
            $table->unsignedBigInteger('appointment_with');
            $table->date('appointment_date');
            $table->unsignedBigInteger('available_time');
            $table->unsignedBigInteger('available_slot');
            $table->unsignedBigInteger('booked_by');
            $table->string('status')->default(0)->comment('0=>pending,1=>complete,2=>cancel');
            $table->tinyInteger('is_deleted')->default(0)->comment('0=>active,1=>inactive');
            $table->foreign('booked_by')->references('id')->on('users');
            $table->foreign('appointment_for')->references('id')->on('users');
            $table->foreign('appointment_with')->references('id')->on('users');
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
        Schema::dropIfExists('appointments');
    }
}
