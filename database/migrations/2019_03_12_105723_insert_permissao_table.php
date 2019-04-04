<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertPermissaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {
        DB::table('permissao')->insert(
            ['nome' => 'Pessoas', 'nickname' => 'PERSON']
        );

        DB::table('permissao')->insert(
            ['nome' => 'Históricos', 'nickname' => 'HISTORY']
        );

        DB::table('permissao')->insert(
            ['nome' => 'Relatórios', 'nickname' => 'REPORT']
        );

        DB::table('permissao')->insert(
            ['nome' => 'Serviços', 'nickname' => 'SERVICE']
        );





        DB::table('user_permissao')->insert(
            ['id_user' => 1, 'id_permissao' => 2]
        );
        DB::table('user_permissao')->insert(
            ['id_user' => 1, 'id_permissao' => 3]
        );
        DB::table('user_permissao')->insert(
            ['id_user' => 1, 'id_permissao' => 4]
        );
        DB::table('user_permissao')->insert(
            ['id_user' => 1, 'id_permissao' => 5]
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
