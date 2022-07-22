<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsIgnoredColumnToExcelSheets extends Migration
{

    public function up()
    {
        Schema::table('excel_sheets', function (Blueprint $table) {
            $table->tinyInteger('is_ignored')->default(0)->after('is_edited');
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
