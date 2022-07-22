<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditedColumnsToExcelSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('excel_sheets', function (Blueprint $table) {
            $table->string('edited_columns')->nullable(true)->after('is_edited');
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
