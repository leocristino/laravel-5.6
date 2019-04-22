<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertNewPermissionPaymentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissao')->insert(
            ['nome' => 'Formas de Pagamento', 'nickname' => 'PAYMENT_TYPE']
        );

        DB::table('user_permissao')->insert(
            ['id_user' => 1, 'id_permissao' => 7]
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
