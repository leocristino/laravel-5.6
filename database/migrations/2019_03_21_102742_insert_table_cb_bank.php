<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertTableCbBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('cb_bank')->insert(['id' => 1, 'name' => 'BANCO DO BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 3, 'name' => 'BANCO DA AMAZONIA S.A.']);
        DB::table('cb_bank')->insert(['id' => 4, 'name' => 'BANCO DO NORDESTE DO BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 19, 'name' => 'BANCO AZTECA DO BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 21, 'name' => 'BANESTES S.A. BANCO DO ESTADO DO ESPIRITO SANTO']);
        DB::table('cb_bank')->insert(['id' => 25, 'name' => 'BANCO ALFA S.A']);
        DB::table('cb_bank')->insert(['id' => 33, 'name' => 'BANCO SANTANDER BANESPA S.A.']);
        DB::table('cb_bank')->insert(['id' => 37, 'name' => 'BANCO DO ESTADO DO PARÁ S.A.']);
        DB::table('cb_bank')->insert(['id' => 40, 'name' => 'BANCO CARGILL S.A.']);
        DB::table('cb_bank')->insert(['id' => 41, 'name' => 'BANCO DO ESTADO DO RIO GRANDE DO SUL S.A.']);
        DB::table('cb_bank')->insert(['id' => 44, 'name' => 'BANCO BVA S.A.']);
        DB::table('cb_bank')->insert(['id' => 45, 'name' => 'BANCO OPPORTUNITY S.A.']);
        DB::table('cb_bank')->insert(['id' => 47, 'name' => 'BANCO DO ESTADO DE SERGIPE S.A.']);
        DB::table('cb_bank')->insert(['id' => 62, 'name' => 'HIPERCARD BANCO MÚLTIPLO S.A.']);
        DB::table('cb_bank')->insert(['id' => 63, 'name' => 'BANCO IBI S.A. - BANCO MÚLTIPLO']);
        DB::table('cb_bank')->insert(['id' => 65, 'name' => 'BANCO LEMON S.A.']);
        DB::table('cb_bank')->insert(['id' => 66, 'name' => 'BANCO MORGAN STANLEY S.A.']);
        DB::table('cb_bank')->insert(['id' => 69, 'name' => 'BPN BRASIL BANCO MÚLTIPLO S.A.']);
        DB::table('cb_bank')->insert(['id' => 70, 'name' => 'BRB - BANCO DE BRASILIA S.A.']);
        DB::table('cb_bank')->insert(['id' => 72, 'name' => 'BANCO RURAL MAIS S.A.']);
        DB::table('cb_bank')->insert(['id' => 73, 'name' => 'BB BANCO POPULAR DO BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 74, 'name' => 'BANCO J. SAFRA S.A.']);
        DB::table('cb_bank')->insert(['id' => 75, 'name' => 'BANCO CR2 S/A']);
        DB::table('cb_bank')->insert(['id' => 76, 'name' => 'BANCO KDB DO BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 77, 'name' => 'BANCO INTERMEDIUM S/A']);
        DB::table('cb_bank')->insert(['id' => 79, 'name' => 'JBS BANCO S/A']);
        DB::table('cb_bank')->insert(['id' => 81, 'name' => 'CONCÓRDIA BANCO S.A.']);
        DB::table('cb_bank')->insert(['id' => 96, 'name' => 'BANCO BM&F DE SERVIÇOS DE LIQUIDAÇÃO E CUSTÓDIA S.A.']);
        DB::table('cb_bank')->insert(['id' => 104, 'name' => 'CAIXA ECONOMICA FEDERAL']);
        DB::table('cb_bank')->insert(['id' => 107, 'name' => 'BANCO BBM S/A']);
        DB::table('cb_bank')->insert(['id' => 151, 'name' => 'BANCO NOSSA CAIXA S.A.']);
        DB::table('cb_bank')->insert(['id' => 208, 'name' => 'BANCO UBS PACTUAL S.A.']);
        DB::table('cb_bank')->insert(['id' => 212, 'name' => 'BANCO MATONE S.A.']);
        DB::table('cb_bank')->insert(['id' => 213, 'name' => 'BANCO ARBI S.A.']);
        DB::table('cb_bank')->insert(['id' => 214, 'name' => 'BANCO DIBENS S.A.']);
        DB::table('cb_bank')->insert(['id' => 217, 'name' => 'BANCO JOHN DEERE S.A.']);
        DB::table('cb_bank')->insert(['id' => 218, 'name' => 'BANCO BONSUCESSO S.A.']);
        DB::table('cb_bank')->insert(['id' => 222, 'name' => 'BANCO CALYON BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 224, 'name' => 'BANCO FIBRA S.A.']);
        DB::table('cb_bank')->insert(['id' => 225, 'name' => 'BANCO BRASCAN S.A.']);
        DB::table('cb_bank')->insert(['id' => 229, 'name' => 'BANCO CRUZEIRO DO SUL S.A.']);
        DB::table('cb_bank')->insert(['id' => 230, 'name' => 'UNICARD BANCO MÚLTIPLO S.A.']);
        DB::table('cb_bank')->insert(['id' => 233, 'name' => 'BANCO GE CAPITAL S.A.']);
        DB::table('cb_bank')->insert(['id' => 237, 'name' => 'BANCO BRADESCO S.A.']);
        DB::table('cb_bank')->insert(['id' => 241, 'name' => 'BANCO CLASSICO S.A.']);
        DB::table('cb_bank')->insert(['id' => 243, 'name' => 'BANCO MÁXIMA S.A.']);
        DB::table('cb_bank')->insert(['id' => 246, 'name' => 'BANCO ABC BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 248, 'name' => 'BANCO BOAVISTA INTERATLANTICO S.A.']);
        DB::table('cb_bank')->insert(['id' => 249, 'name' => 'BANCO INVESTCRED UNIBANCO S.A.']);
        DB::table('cb_bank')->insert(['id' => 250, 'name' => 'BANCO SCHAHIN S.A.']);
        DB::table('cb_bank')->insert(['id' => 254, 'name' => 'PARANÁ BANCO S.A.']);
        DB::table('cb_bank')->insert(['id' => 263, 'name' => 'BANCO CACIQUE S.A.']);
        DB::table('cb_bank')->insert(['id' => 265, 'name' => 'BANCO FATOR S.A.']);
        DB::table('cb_bank')->insert(['id' => 266, 'name' => 'BANCO CEDULA S.A.']);
        DB::table('cb_bank')->insert(['id' => 300, 'name' => 'BANCO DE LA NACION ARGENTINA']);
        DB::table('cb_bank')->insert(['id' => 318, 'name' => 'BANCO BMG S.A.']);
        DB::table('cb_bank')->insert(['id' => 341, 'name' => 'BANCO ITAÚ S.A.']);
        DB::table('cb_bank')->insert(['id' => 356, 'name' => 'BANCO ABN AMRO REAL S.A.']);
        DB::table('cb_bank')->insert(['id' => 366, 'name' => 'BANCO SOCIETE GENERALE BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 370, 'name' => 'BANCO WESTLB DO BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 376, 'name' => 'BANCO J.P. MORGAN S.A.']);
        DB::table('cb_bank')->insert(['id' => 389, 'name' => 'BANCO MERCANTIL DO BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 394, 'name' => 'BANCO FINASA BMC S.A.']);
        DB::table('cb_bank')->insert(['id' => 399, 'name' => 'HSBC BANK BRASIL S.A. - BANCO MULTIPLO']);
        DB::table('cb_bank')->insert(['id' => 409, 'name' => 'UNIBANCO-UNIAO DE BANCOS BRASILEIROS S.A.']);
        DB::table('cb_bank')->insert(['id' => 412, 'name' => 'BANCO CAPITAL S.A.']);
        DB::table('cb_bank')->insert(['id' => 422, 'name' => 'BANCO SAFRA S.A.']);
        DB::table('cb_bank')->insert(['id' => 453, 'name' => 'BANCO RURAL S.A.']);
        DB::table('cb_bank')->insert(['id' => 456, 'name' => 'BANCO DE TOKYO-MITSUBISHI UFJ BRASIL S/A']);
        DB::table('cb_bank')->insert(['id' => 464, 'name' => 'BANCO SUMITOMO MITSUI BRASILEIRO S.A.']);
        DB::table('cb_bank')->insert(['id' => 477, 'name' => 'CITIBANK N.A.']);
        DB::table('cb_bank')->insert(['id' => 487, 'name' => 'DEUTSCHE BANK S.A. - BANCO ALEMAO']);
        DB::table('cb_bank')->insert(['id' => 488, 'name' => 'JPMORGAN CHASE BANK, NATIONAL ASSOCIATION']);
        DB::table('cb_bank')->insert(['id' => 492, 'name' => 'ING BANK N.V.']);
        DB::table('cb_bank')->insert(['id' => 494, 'name' => 'BANCO DE LA REPUBLICA ORIENTAL DEL URUGUAY']);
        DB::table('cb_bank')->insert(['id' => 495, 'name' => 'BANCO DE LA PROVINCIA DE BUENOS AIRES']);
        DB::table('cb_bank')->insert(['id' => 505, 'name' => 'BANCO CREDIT SUISSE (BRASIL) S.A.']);
        DB::table('cb_bank')->insert(['id' => 600, 'name' => 'BANCO LUSO BRASILEIRO S.A.']);
        DB::table('cb_bank')->insert(['id' => 604, 'name' => 'BANCO INDUSTRIAL DO BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 610, 'name' => 'BANCO VR S.A.']);
        DB::table('cb_bank')->insert(['id' => 611, 'name' => 'BANCO PAULISTA S.A.']);
        DB::table('cb_bank')->insert(['id' => 612, 'name' => 'BANCO GUANABARA S.A.']);
        DB::table('cb_bank')->insert(['id' => 613, 'name' => 'BANCO PECUNIA S.A.']);
        DB::table('cb_bank')->insert(['id' => 623, 'name' => 'BANCO PANAMERICANO S.A.']);
        DB::table('cb_bank')->insert(['id' => 626, 'name' => 'BANCO FICSA S.A.']);
        DB::table('cb_bank')->insert(['id' => 630, 'name' => 'BANCO INTERCAP S.A.']);
        DB::table('cb_bank')->insert(['id' => 633, 'name' => 'BANCO RENDIMENTO S.A.']);
        DB::table('cb_bank')->insert(['id' => 634, 'name' => 'BANCO TRIANGULO S.A.']);
        DB::table('cb_bank')->insert(['id' => 637, 'name' => 'BANCO SOFISA S.A.']);
        DB::table('cb_bank')->insert(['id' => 638, 'name' => 'BANCO PROSPER S.A.']);
        DB::table('cb_bank')->insert(['id' => 643, 'name' => 'BANCO PINE S.A.']);
        DB::table('cb_bank')->insert(['id' => 653, 'name' => 'BANCO INDUSVAL S.A.']);
        DB::table('cb_bank')->insert(['id' => 654, 'name' => 'BANCO A.J. RENNER S.A.']);
        DB::table('cb_bank')->insert(['id' => 655, 'name' => 'BANCO VOTORANTIM S.A.']);
        DB::table('cb_bank')->insert(['id' => 707, 'name' => 'BANCO DAYCOVAL S.A.']);
        DB::table('cb_bank')->insert(['id' => 719, 'name' => 'BANIF - BANCO INTERNACIONAL DO FUNCHAL (BRASIL), S.A.']);
        DB::table('cb_bank')->insert(['id' => 721, 'name' => 'BANCO CREDIBEL S.A.']);
        DB::table('cb_bank')->insert(['id' => 734, 'name' => 'BANCO GERDAU S.A']);
        DB::table('cb_bank')->insert(['id' => 735, 'name' => 'BANCO POTTENCIAL S.A.']);
        DB::table('cb_bank')->insert(['id' => 738, 'name' => 'BANCO MORADA S.A.']);
        DB::table('cb_bank')->insert(['id' => 739, 'name' => 'BANCO BGN S.A.']);
        DB::table('cb_bank')->insert(['id' => 740, 'name' => 'BANCO BARCLAYS S.A.']);
        DB::table('cb_bank')->insert(['id' => 741, 'name' => 'BANCO RIBEIRAO PRETO S.A.']);
        DB::table('cb_bank')->insert(['id' => 743, 'name' => 'BANCO EMBLEMA S.A.']);
        DB::table('cb_bank')->insert(['id' => 745, 'name' => 'BANCO CITIBANK S.A.']);
        DB::table('cb_bank')->insert(['id' => 746, 'name' => 'BANCO MODAL S.A.']);
        DB::table('cb_bank')->insert(['id' => 747, 'name' => 'BANCO RABOBANK INTERNATIONAL BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 748, 'name' => 'BANCO COOPERATIVO SICREDI S.A.']);
        DB::table('cb_bank')->insert(['id' => 749, 'name' => 'BANCO SIMPLES S.A.']);
        DB::table('cb_bank')->insert(['id' => 751, 'name' => 'DRESDNER BANK BRASIL S.A. BANCO MULTIPLO']);
        DB::table('cb_bank')->insert(['id' => 752, 'name' => 'BANCO BNP PARIBAS BRASIL S.A.']);
        DB::table('cb_bank')->insert(['id' => 753, 'name' => 'NBC BANK BRASIL S. A. - BANCO MÚLTIPLO']);
        DB::table('cb_bank')->insert(['id' => 756, 'name' => 'BANCO COOPERATIVO DO BRASIL S.A. - BANCOOB']);
        DB::table('cb_bank')->insert(['id' => 757, 'name' => 'BANCO KEB DO BRASIL S.A.']);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('cb_bank')->delete();
    }
}
