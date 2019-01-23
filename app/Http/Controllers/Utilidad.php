<?php

namespace App\Http\Controllers;

use GrahamCampbell\Flysystem\Facades\Flysystem;
use Intervention\Image\Facades\Image;

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

    public static function getPathPublic(){
        return __DIR__ . '/../../../public';
    }

    public static function CrearDirectorioInspeccion($Inspeccion)
    {
        Flysystem::createDir('Inspeccion/insp_' . ($Inspeccion));
        Flysystem::createDir('Inspeccion/insp_' . ($Inspeccion) . '/Anexos');
    }


    public static function ListarDirectorioInspeccion($Inspeccion)
    {
        $path = 'Inspeccion/insp_' . ($Inspeccion). '/Anexos';
        $contents = Flysystem::listContents($path, true);
        return $contents;
    }

    public static function leerArchivo($path)
    {
        $stream = Flysystem::readStream($path);
        $contents_stream = stream_get_contents($stream);
        return $contents_stream;
    }

    public static function base64Img($path){
//        $image = 'cricci.jpg';
//        $stream = Flysystem::readStream($path);
//        $imageData = base64_encode(stream_get_contents($stream));
//        return 'data:image/png;base64,'.$imageData;


        return (string) Image::make($path)->resize(320, 240)->encode('data-url');

    }



    /* Anotaciones */
//            return response($content)
//            ->header('Content-Type','image/png')
//            ->header('Pragma','public')
//            ->header('Content-Disposition','inline; filename="qrcodeimg.png"')
//            ->header('Cache-Control','max-age=60, must-revalidate');


}