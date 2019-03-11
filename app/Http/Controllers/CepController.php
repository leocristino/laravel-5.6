<?php

namespace App\Http\Controllers;

use App\Models\Cep;
use Illuminate\Http\Request;

class CepController extends Controller
{
    public function findCep(Request $request)
    {
        $cep = $request->get('cep');

        $address = Cep::getCep($cep);
        if($address === false){
            return response()->view('', [], 500);
        }else{
            return $address;
        }
    }

    public function findCidades(Request $request)
    {
        $uf = $request->get('uf');

        $cidades = Cep::getCidadesUf($uf);
        if($cidades === false){
            return response()->view('', [], 500);
        }else{
            return $cidades;
        }
    }
}
