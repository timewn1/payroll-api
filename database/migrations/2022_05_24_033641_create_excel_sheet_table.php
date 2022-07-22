<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcelSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excel_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('dept')->nullable(true);
            $table->integer('user_id')->nullable(true);
            $table->string('name')->nullable(true);
            $table->integer('enroll_id')->nullable(true);
            $table->date('date')->nullable(true);
            $table->string('time_in')->nullable(true);
            $table->string('time_in_lunch')->nullable(true);
            $table->string('time_out_lunch')->nullable(true);
            $table->string('time_out')->nullable(true);
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
        Schema::dropIfExists('excel_sheets');
    }
}
