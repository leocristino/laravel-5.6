<?php

namespace App\Models;

use App\Models\Helpers\CawHelpers;
use DB;
use Illuminate\Database\Eloquent\Model;

class Cep extends Model
{

    public static function CepDB()
    {
        return DB::connection(config("database.connections.cep.database"));
    }

    public static function listaUFs(){
        return ['AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI',
            'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO'];
    }

    public static function getCidadesUf($uf){

        if(!in_array($uf, Cep::listaUFs()))
        {
            return false;
        }

        $sql = "select c.cidade_codigo as value/*, c.cidade_descricao as value*/, c.cidade_descricao as text
            from uf join cidade c on c.uf_codigo = uf.uf_codigo
            where uf.uf_sigla = :uf
            order by c.cidade_descricao";


        $cidades = Cep::CepDB()->select(DB::raw($sql), ['uf' => $uf]);
        if(!empty($cidades)){
            return $cidades;
        }else{
            return false;
        }
    }

    public static function getCep($cep)
    {
        $cep = CawHelpers::removeFormatting($cep);

        if (strlen($cep) != 8) {
            return false;
        }

        $sql = "select e.endereco_logradouro as logradouro, c.cidade_codigo, c.cidade_descricao as cidade, b.bairro_descricao as bairro, uf.uf_sigla as uf
                from cidade c
                join uf on uf.uf_codigo = c.uf_codigo
                left outer join bairro b on b.cidade_codigo = c.cidade_codigo
                left outer join endereco e on b.bairro_codigo = e.bairro_codigo
                where e.endereco_cep = :cep1 or c.cidade_cep = :cep2
                limit 1";

        $address = Cep::CepDB()->select($sql, ['cep1' => $cep, 'cep2' => $cep]);
        if(!empty($address)){
            return $address;
        }else{
            return false;
        }
    }
}