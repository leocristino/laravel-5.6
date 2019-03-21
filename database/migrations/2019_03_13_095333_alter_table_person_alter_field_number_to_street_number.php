<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePersonAlterFieldNumberToStreetNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('person', function($table)
        {
            $table->engine = 'InnoDB';
            $table->renameColumn('number', 'street_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('person', function($table)
        {
            $table->renameColumn('street_number', 'number');
        });
    }
}
