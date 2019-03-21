<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableHistoryAddForeingKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history', function($table) {
            DB::statement('ALTER TABLE `history` DROP `id_person`;');
        });

        Schema::table('history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('id_person');
            $table->foreign('id_person')->references('id')->on('person')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history', function (Blueprint $table) {
            $table->dropForeign('telefones_tipo_telefone_id_foreign');
            $table->dropColumn('id_person');
        });
    }
}
