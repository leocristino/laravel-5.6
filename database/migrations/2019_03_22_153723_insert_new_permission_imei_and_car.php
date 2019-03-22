<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertNewPermissionImeiAndCar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissao')->insert(
            ['nome' => 'Imei', 'nickname' => 'IMEI']
        );

        DB::table('permissao')->insert(
            ['nome' => 'Carros', 'nickname' => 'CAR']
        );

        DB::table('user_permissao')->insert(
            ['id_user' => 1, 'id_permissao' => 10]
        );

        DB::table('user_permissao')->insert(
            ['id_user' => 1, 'id_permissao' => 11]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
