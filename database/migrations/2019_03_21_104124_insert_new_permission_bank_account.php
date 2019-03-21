<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertNewPermissionBankAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissao')->insert(
            ['nome' => 'Conta Corrente', 'nickname' => 'BANK_ACCOUNT']
        );

        DB::table('user_permissao')->insert(
            ['id_user' => 1, 'id_permissao' => 7]
        );

        DB::table('user_permissao')->insert(
            ['id_user' => 1, 'id_permissao' => 8]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissao')->where('nickname', '=', 'BANK_ACCOUNT')->delete();
    }
}
