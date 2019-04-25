<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertCompanyOnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('company')->insert(
            [
                'name'              => 'Tatical Force Monitoramento LTDa',
                'cpf_cnpj'          => '26.363.682/0001-90',
                'street'            => 'Rua 13 de maio',
                'street_number'     => '88',
                'state'             => 'SP',
                'email'             => 'contato@taticalmonitoramento.com.br',
                'zip'               => '14.680-000',
                'district'          => 'PERSON',
                'city'              => 'Jardinópolis',
                'complement'        => 'N/A',
                'fixed_telephone'   => '(16) 3663-9190',
                'cellphone'         => '(16) 3663-9490',
            ]
        );

        DB::table('company')->insert(
            [   'name'              => 'Marcela Pereira de Oliveira Dias',
                'cpf_cnpj'          => '294.499.848-08',
                'street'            => 'Rua 13 de maio',
                'street_number'     => '88',
                'state'             => 'SP',
                'email'             => 'contato@taticalmonitoramento.com.br',
                'zip'               => '14.680-000',
                'district'          => 'PERSON',
                'city'              => 'Jardinópolis',
                'complement'        => 'N/A',
                'fixed_telephone'   => '(16) 3663-9190',
                'cellphone'         => '(16) 3663-9490',
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('company')->delete();
    }
}
