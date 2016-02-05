<?php

namespace App\Models;

class ModelHelper
{
    
    public static function removeAccent($value)
    {
    	return preg_replace('/[^\wW\s]/', ' ', iconv("utf-8", "ascii//TRANSLIT", $value));
    }

    public static function realCurrency($value)
    {
		return "R$ " . number_format($value, 2, ',' ,'.');
    }

    public static function brDate($value)
    {
		return preg_replace("/(\d{4})-(\d{2})-(\d{2})/", "$3/$2/$1", $value);
    }

    public static function urlEncode($value)
    {
        return urlencode(str_replace('/', '$', $value));
    }

    public static function urlDecode($value)
    {
        return str_replace('$','/',urldecode($value));
    }    

    public static function soma($items)
    {
        $sum = 0;
        foreach($items as $item) {
            $sum += preg_replace('/[^\d]/', '', $item->Valor)/100;
        }
        return self::realCurrency($sum);
    }    

}
