<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertForeingIdContractInCarAndImei extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_imei', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->foreign('id_contract')->references('id')->on('contract')->onDelete('cascade')->onUpdate('cascade');

        });

        Schema::table('contract_car', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->foreign('id_contract')->references('id')->on('contract')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_car', function (Blueprint $table) {
            $table->dropForeign(['id_contract']);

        });

        Schema::table('contract_imei', function (Blueprint $table) {
            $table->dropForeign(['id_contract']);

        });
    }
}
