<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBankAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_account', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name',100);
            $table->unsignedInteger('id_bank');
            $table->foreign('id_bank')->references('id')->on('cb_bank')->onDelete('cascade')->onUpdate('cascade');
            $table->string('agency', 50)->nullable();
            $table->string('account_current', 20)->nullable();
            $table->decimal('currentBalance',8,2)->nullable();
            $table->date('balance_date');
            $table->string('bill_option',1)->nullable();
            $table->string('wallet',50)->nullable();
            $table->string('special_code', 100)->nullable();
            $table->string('pact', 100)->nullable();
            $table->string('transmission_code', 100)->nullable();
            $table->string('complement', 100)->nullable();
            $table->string('local_pay', 100)->nullable();
            $table->string('instruction', 100)->nullable();
            $table->string('who_send_ticket', 100)->nullable();
            $table->decimal('priceOfSend', 8,2);
            $table->tinyInteger('active')->default(0);
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
        Schema::table('bank_account', function (Blueprint $table) {
            //
        });
    }
}
