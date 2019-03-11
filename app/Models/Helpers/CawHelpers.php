<?php
/**
 * Created by PhpStorm.
 * User: Valerio
 * Date: 05/05/2018
 * Time: 16:07
 */

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Builder;

class CawHelpers
{
    public static function addWhereLike(Builder &$builder, $fieldname, $value){
        if(!empty($value)){
            $builder->where($fieldname, 'like', '%'.$value.'%');
        }
    }

    public static function addOrWhereLike(Builder &$builder, $fieldname, $value){
        if(!empty($value)){
            $builder->orWhere($fieldname, 'like', '%'.$value.'%');
        }
    }

    public static function removeFormatting($str){
        return preg_replace('/[^0-9]/','',$str);
    }

    //validações
    public static function isCPF($cpf){
        $cpf_limpo = CawHelpers::removeFormatting($cpf);

        if (strlen($cpf_limpo)!=11)
            return false;

        if (($cpf_limpo == '11111111111') || ($cpf_limpo == '22222222222') || ($cpf_limpo == '33333333333') ||
            ($cpf_limpo == '44444444444') || ($cpf_limpo == '55555555555') || ($cpf_limpo == '66666666666') || ($cpf_limpo == '77777777777') ||
            ($cpf_limpo == '88888888888') || ($cpf_limpo == '99999999999') || ($cpf_limpo == '00000000000'))
            return false;

        // achar o primeiro digito verificador
        $soma = 0;
        for ($i=0; $i<9; $i++)
            $soma += (int)substr($cpf_limpo, $i, 1) * (10-$i);

        if ($soma == 0)
            return false;

        $primeiro_digito = 11 - $soma % 11;

        if ($primeiro_digito > 9)
            $primeiro_digito = 0;

        if (substr($cpf_limpo, 9, 1) != $primeiro_digito)
            return false;

        // acha o segundo digito verificador
        $soma = 0;
        for ($i=0; $i<10; $i++)
            $soma += (int)substr($cpf_limpo, $i, 1) * (11-$i);

        $segundo_digito = 11 - $soma % 11;

        if ($segundo_digito > 9)
            $segundo_digito = 0;

        if (substr($cpf_limpo, 10, 1) != $segundo_digito)
            return false;

        return true;
    }

    // ------------------------------------------------------------------------------
    // * validaCNPJ: Verifica se é um CNPJ válido
    // ------------------------------------------------------------------------------
    public static function isCNPJ($cnpj)
    {
        $cnpj = CawHelpers::removeFormatting($cnpj);

        if(empty($cnpj) || strlen($cnpj) != 14)
            return FALSE;
        else
            if (($cnpj == '11111111111111') || ($cnpj == '22222222222222') || ($cnpj == '33333333333333') ||
                ($cnpj == '44444444444444') || ($cnpj == '55555555555555') || ($cnpj == '66666666666666') || ($cnpj == '77777777777777') ||
                ($cnpj == '88888888888888') || ($cnpj == '99999999999999') || ($cnpj == '00000000000000'))
                return false;
            else
            {
                /*if(check_fake($cnpj,14))
                    return FALSE;
                else*/
                {
                    $rev_cnpj = strrev(substr($cnpj, 0, 12));
                    $sum = 0;
                    $multiplier = 0;
                    for ($i = 0; $i <= 11; $i++)
                    {
                        $i == 0 ? $multiplier = 2 : $multiplier;
                        $i == 8 ? $multiplier = 2 : $multiplier;
                        $multiply = ($rev_cnpj[$i] * $multiplier);
                        $sum = $sum + $multiply;
                        $multiplier++;
                    }
                    $rest = $sum % 11;
                    if ($rest == 0 || $rest == 1)
                        $dv1 = 0;
                    else
                        $dv1 = 11 - $rest;

                    $sub_cnpj = substr($cnpj, 0, 12);
                    $rev_cnpj = strrev($sub_cnpj.$dv1);
                    $sum = 0;
                    for ($i = 0; $i <= 12; $i++)
                    {
                        $i == 0 ? $multiplier = 2 : $multiplier;
                        $i == 8 ? $multiplier = 2 : $multiplier;
                        $multiply = ($rev_cnpj[$i] * $multiplier);
                        $sum = $sum + $multiply;
                        $multiplier++;
                    }
                    $rest = $sum % 11;
                    if ($rest == 0 || $rest == 1)
                        $dv2 = 0;
                    else
                        $dv2 = 11 - $rest;

                    if ($dv1 == $cnpj[12] && $dv2 == $cnpj[13])
                        return true; //$cnpj;
                    else
                        return false;
                }
            }
    }

    public static function encodeData($_data, $with_time = false){
        if(!is_numeric(substr($_data,6, 4)) || substr($_data,6, 4) < 1900 || substr($_data,6, 4) > 2100 ||
            !is_numeric(substr($_data,3, 2)) || substr($_data,3, 2) < 1 || substr($_data,3, 2) > 12 ||
            !is_numeric(substr($_data,0, 2)) || substr($_data,0, 2) < 1 || substr($_data,0, 2) > 31)
            return "";
        $_newdata = substr($_data,6, 4);
        $_newdata .= '-'.substr($_data,3, 2);
        $_newdata .= '-'.substr($_data,0, 2);

        if(!$with_time) {
            $_newdata = substr($_newdata, 0, 10);
        }

        if(strtotime($_newdata)){
            return $_newdata;
        }

        return false;
    }

    public static function decodeData($value, $with_time = false){
        if(strtotime($value)){
            if(!$with_time) {
                return date('d/m/Y', strtotime($value));
            }else{
                return date('d/m/Y H:i:s', strtotime($value));
            }
        }
        return false;
    }

    public static function encodeMoeda($_value){
        $_value = str_replace('.', '', $_value);
        $_value = str_replace(',', '.', $_value);
        $_value = (is_numeric($_value) ? $_value : 0);
        return $_value;
    }

    public static function decodeMoeda($_value, $casas_decimais = 2){
        if(!is_numeric($_value)) {
            return 0;
        } else {
            return number_format($_value, $casas_decimais, ',', '.');
        }
    }

    //Mask para telefone
    public static function mask_telefone($telefone){

        $telefone = "(".substr($telefone,0,2).") ".substr($telefone,2,-4)."-".substr($telefone,-4);

        return $telefone;
    }

    //Mask para cpf, cnpj, data, hora e o que deseja
    public static function mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset ($val[$k]))
                    $maskared .= $val[$k++];
            } else {
                if (isset ($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}