<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFinancialLaunch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_launch', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->unsignedInteger('id_person');
            $table->foreign('id_person')->references('id')->on('person')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('id_ticket');
            $table->foreign('id_ticket')->references('id')->on('ticket')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('id_payment_type');
            $table->foreign('id_payment_type')->references('id')->on('payment_type')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('id_bank_account')->nullable(true);
            $table->foreign('id_bank_account')->references('id')->on('bank_account')->onDelete('cascade')->onUpdate('cascade');

            // P para contars a pagar  e R para contas a receger
            $table->char('account_type',1);
            $table->string('description',255)->nullable(true);
            $table->date('due_date');
            $table->decimal('value_bill',8,2);
            $table->date('payment_date')->nullable(true);
            $table->decimal('amount_paid',8,2)->nullable(true);
            $table->string('description_bank_return',255)->nullable(true);
            $table->string('chq_bank', 100)->nullable(true);
            $table->string('chq_agency',30)->nullable(true);
            $table->string('chq_current_account',30)->nullable(true);
            $table->string('chq_number',30)->nullable(true);
            $table->string('chq_reason_return',50)->nullable(true);
            $table->date('chq_date_return')->nullable(true);
            $table->string('chq_lot',50)->nullable(true);

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
        Schema::dropIfExists('financial_launch');
    }
}
