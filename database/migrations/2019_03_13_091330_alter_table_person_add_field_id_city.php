<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePersonAddFieldIdCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('person', function (Blueprint $table) {
            $table->integer("id_city")->nullable(true)->after("obs");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('person', function (Blueprint $table) {
            $table->dropColumn("id_city");
        });
    }
}
