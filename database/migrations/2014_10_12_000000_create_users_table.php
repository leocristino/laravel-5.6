<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('active')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('permissao', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('nome', 100);
            $table->string('nickname', 100);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('user_permissao', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('id_permissao');
            $table->foreign('id_permissao')->references('id')->on('permissao')->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('user')->insert(
            ['name' => 'administrador','email' => 'admin@admin.com' , 'password' => bcrypt('123456'), 'active' => 1]
        );

        DB::table('permissao')->insert(
            ['nome' => 'Usuários', 'nickname' => 'USER']
        );

        DB::table('user_permissao')->insert(
            ['id_user' => 1, 'id_permissao' => 1]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_permissao');
        Schema::dropIfExists('permissao');
        Schema::dropIfExists('user');
    }
}