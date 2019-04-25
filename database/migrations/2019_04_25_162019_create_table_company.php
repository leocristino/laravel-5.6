<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name',200);
            $table->string('cpf_cnpj',20);
            $table->string('street',100);
            $table->integer('street_number');
            $table->string('state',100);
            $table->string('email',100);
            $table->string('zip',15);
            $table->string('district',25);
            $table->string('city',30);
            $table->string('complement',15);
            $table->string('fixed_telephone',20);
            $table->string('cellphone',20);
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
        Schema::dropIfExists('company');
    }
}
