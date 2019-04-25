<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableFinancialLaunchAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_launch', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer("contract_number")->nullable(true)->after('lot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_launch', function (Blueprint $table) {
            $table->dropColumn("contract_number");
        });
    }
}
