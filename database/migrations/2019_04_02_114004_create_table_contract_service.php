<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContractService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->index();

            $table->unsignedInteger('id_contract');
            $table->foreign('id_contract')->references('id')->on('contract')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('id_service');
            $table->foreign('id_service')->references('id')->on('service')->onDelete('cascade')->onUpdate('cascade');

            $table->decimal('value',18,2);
            $table->decimal('addition_discount',18,2);

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
        Schema::table('contract_service', function (Blueprint $table) {
            //
        });
    }
}
