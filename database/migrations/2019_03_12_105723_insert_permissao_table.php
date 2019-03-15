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
            ['nome' => 'Gestão de Pessoas', 'nickname' => 'PERSON']
        );

        DB::table('permissao')->insert(
            ['nome' => 'Histórico do Cliente', 'nickname' => 'HISTORY']
        );

        DB::table('permissao')->insert(
            ['nome' => 'Relatórios', 'nickname' => 'REPORT']
        );

        DB::table('permissao')->insert(
            ['nome' => 'Serviços contratados', 'nickname' => 'SERVICES']
        );

        DB::table('permissao')->insert(
            ['nome' => 'Financeiro', 'nickname' => 'FINANCIAL']
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
        DB::table('user_permissao')->insert(
            ['id_user' => 1, 'id_permissao' => 6]
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
