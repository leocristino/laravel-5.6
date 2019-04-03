<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableContractAddColumnIdBankAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract', function (Blueprint $table) {
            $table->unsignedInteger('id_bank_account')->nullable()->after('id_payment_type');
            $table->foreign('id_bank_account')->references('id')->on('bank_account')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract', function (Blueprint $table) {
            $table->dropForeign('contract_id_bank_account_foreign');
            $table->dropColumn('id_bank_account');
        });

    }
}
