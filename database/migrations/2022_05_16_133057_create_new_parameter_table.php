<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewParameterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_parameter', function (Blueprint $table) {
            $table->id();
            $table->string('parameter');
            $table->string('type');
            $table->string('unit')->nullable();
            $table->string('abbreviations')->nullable();
            $table->string('standard_value')->nullable();
            $table->string('formula')->nullable();
            $table->string('size')->nullable();
            $table->string('decimal_places')->nullable();
            $table->tinyInteger('decimal_mask')->default(0)->comment('0=>no,1=>yes');
            $table->string('minimum')->nullable();
            $table->string('maximum')->nullable();
            $table->tinyInteger('block_recording')->default(0)->comment('0=>no,1=>yes');
            $table->tinyInteger('mandatory_parameter')->default(0)->comment('0=>no,1=>yes');
            $table->tinyInteger('imp_ruler')->default(1)->comment('0=>no,1=>yes');
            $table->tinyInteger('previous_imp')->default(1)->comment('0=>no,1=>yes');
            $table->text('description')->nullable();
            $table->string('reference_value')->nullable();
            $table->string('support_parameter')->nullable();
            $table->tinyInteger('evolutionary_report_parameter')->default(1)->comment('0=>no,1=>yes');
            $table->softDeletes();
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
        Schema::dropIfExists('new_parameter');
    }
}
