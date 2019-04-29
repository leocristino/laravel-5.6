<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBankAccountAddForeingKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('bank_account', function($table) {
//            DB::statement('ALTER TABLE `bank_account` DROP `id_company`;');
//        });

        Schema::table('bank_account', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('id_company')->after('id_bank');
            $table->foreign('id_company')->references('id')->on('company')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_account', function (Blueprint $table) {
            $table->dropForeign('bank_account_id_company_foreign');
            $table->dropColumn('id_company');
        });
    }
}
