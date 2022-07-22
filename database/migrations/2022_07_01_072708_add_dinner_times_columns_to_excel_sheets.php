<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDinnerTimesColumnsToExcelSheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('excel_sheets', function (Blueprint $table) {
            $table->string("dinner_time_in")->nullable(true)->after('time_out');
            $table->string("dinner_time_out")->nullable(true)->after('dinner_time_in');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('excel_sheets', function (Blueprint $table) {
            //
        });
    }
}
