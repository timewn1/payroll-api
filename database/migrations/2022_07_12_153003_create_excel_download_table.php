<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcelDownloadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excel_download', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable(true);
            $table->string('day')->nullable(true);
            $table->string('dept')->nullable(true);
            $table->integer('employee_id')->nullable(true);
            $table->string('name')->nullable(true);
            $table->string('time_in')->nullable(true);
            $table->string('lunch_time_in')->nullable(true);
            $table->string('lunch_time_out')->nullable(true);
            $table->string('time_out')->nullable(true);
            $table->string('dinner_time_in')->nullable(true);
            $table->string('dinner_time_out')->nullable(true);
            $table->string('ot_time_out')->nullable(true);
            $table->string('working_hours')->nullable(true);
            $table->string('regular')->nullable(true);
            $table->string('ot')->nullable(true);
            $table->string('early_out')->nullable(true);
            $table->string('lunch_duration')->nullable(true);
            $table->string('dinner_duration')->nullable(true);
            $table->string('half_day')->nullable(true);
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
        Schema::dropIfExists('excel_download');
    }
}
