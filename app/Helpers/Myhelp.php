<?php

namespace App\Helpers;

class Myhelp
{
    public static function numberFormat($number)
    {
        return number_format($number, 0, ',', '.');
    }
    public static function dicmalFormat($number)
    {
        return number_format($number, 2, ',', '.');
    }
}
