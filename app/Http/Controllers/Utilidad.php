<?php

namespace App\Http\Controllers;

use GrahamCampbell\Flysystem\Facades\Flysystem;
use Intervention\Image\Facades\Image;

use Morrislaptop\Firestore\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase;

class Utilidad
{

    private $firestore;
    private $firebase;
    /**
     * Utilidad constructor.
     */
    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(dirname(dirname(__DIR__)) . '/secret/inspector-7933a.json');
        $this->firestore = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->createFirestore();

        $this->firebase = (new Firebase\Factory())
            ->withServiceAccount($serviceAccount)
            ->create();
    }
    public function getFirestore(){
        return $this->firestore;
    }
    public function getFirebase(){
        return $this->firebase;
    }

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

    public static function getPathPublic()
    {
        return __DIR__ . '/../../../public';
    }

    public static function CrearDirectorioInspeccion($Inspeccion)
    {
        Flysystem::createDir('Inspeccion/insp_' . ($Inspeccion));
        Flysystem::createDir('Inspeccion/insp_' . ($Inspeccion) . '/Anexos');
    }


    public static function ListarDirectorioInspeccion($Inspeccion)
    {
        $path = 'Inspeccion/insp_' . ($Inspeccion) . '/Anexos';
        $contents = Flysystem::listContents($path, true);
        return $contents;
    }

    public static function leerArchivo($path)
    {
        $stream = Flysystem::readStream($path);
        $contents_stream = stream_get_contents($stream);
        return $contents_stream;
    }

    public static function base64Img($path)
    {
//        $image = 'cricci.jpg';
//        $stream = Flysystem::readStream($path);
//        $imageData = base64_encode(stream_get_contents($stream));
//        return 'data:image/png;base64,'.$imageData;

        return (string)Image::make($path)->resize(320, 240)->encode('data-url');
    }

    public function uploadFile($data, $path){
        $storage = $this->firebase->getStorage();
        $bucket = $storage->getBucket();
        $bucket->upload(
            json_encode($data, JSON_PRETTY_PRINT),
            [
                'name' => $path
            ]
        );
    }




    /* Anotaciones */
//            return response($content)
//            ->header('Content-Type','image/png')
//            ->header('Pragma','public')
//            ->header('Content-Disposition','inline; filename="qrcodeimg.png"')
//            ->header('Cache-Control','max-age=60, must-revalidate');


}