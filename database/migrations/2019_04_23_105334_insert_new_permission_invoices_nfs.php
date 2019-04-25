<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertNewPermissionInvoicesNfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissao')->insert(
            ['nome' => 'Emissão de Boletos e NFS-e', 'nickname' => 'INVOICES_NFS']
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
