<?php

namespace App\Http\Controllers;

class Utilidad
{
    public static function Online()
    {
        $conexion = @fsockopen("www.google.com", 80, $errno, $errstr, 30);
        if (!$conexion) {
            return false;
        } else {
            fclose($conexion);
            return true;
        }
    }
}