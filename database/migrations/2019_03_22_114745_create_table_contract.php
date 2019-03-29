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

            $table->unsignedInteger('id_payment_type');
            $table->foreign('id_payment_type')->references('id')->on('payment_type')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('due_day');
            $table->string('emergency_password',100);
            $table->string('contra_emergency_password',100);
            $table->date('start_date');
            $table->date('end_date')->nullable(true);
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
