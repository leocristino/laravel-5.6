<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type', 1);
            $table->string('name_social_name', 100)->nullable(true);
            $table->string('fantasy_name', 100)->nullable(true);
            $table->string('cpf_cnpj', 14)->nullable(true);
            $table->string('rg', 20)->nullable(true)->nullable(true);
            $table->string('ie',20)->nullable(true)->nullable(true);
            $table->date('date_birth')->nullable(true)->nullable(true);
            $table->string('email',100)->nullable(true);
            $table->string('zip',8)->nullable(true);
            $table->string('street',100)->nullable(true);
            $table->string('district',30)->nullable(true);
            $table->string('city',50)->nullable(true);
            $table->string('state',2)->nullable(true);
            $table->string('number',20)->nullable(true);
            $table->string('complement',20)->nullable(true);
            $table->string('fixed_telephone',20)->nullable(true);
            $table->string('cellphone',20)->nullable(true);
            $table->text('obs')->nullable(true);
            $table->tinyInteger('active')->default(0);

            $table->softDeletes();
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
        Schema::dropIfExists('person');
    }
}
