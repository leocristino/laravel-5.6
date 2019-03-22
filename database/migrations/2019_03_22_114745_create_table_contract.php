<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->index();

            $table->unsignedInteger('id_person');
            $table->foreign('id_person')->references('id')->on('person')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('id_imei');
            $table->foreign('id_imei')->references('id')->on('imei')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('id_payment_type');
            $table->foreign('id_payment_type')->references('id')->on('payment_type')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('id_car');
            $table->foreign('id_car')->references('id')->on('car')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('dua_day');
            $table->string('emergency_password',100);
            $table->string('contr_emergency_password',100);
            $table->date('start_date');
            $table->date('end_date');




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
        Schema::dropIfExists('contract');
    }
}
