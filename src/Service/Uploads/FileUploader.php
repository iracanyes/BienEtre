<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 24.02.18
 * Time: 05:51
 */

namespace App\Service\Uploads;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception;

class FileUploader
{
    private $uploadsDir;

    public function __construct($uploadsDir)
    {
        $this->uploadsDir = $uploadsDir;
    }

    public function upload(UploadedFile $file)
    {
        // Nom unique
        $fileName = md5(uniqid()).".".$file->guessExtension();

        try{
            // Déplacement du fichier
            $file->move($this->getUploadsDir(), $fileName);

        }catch(FileException $e){
            throw \Exception(
                "Erreur d'upload de fichier : \n"
                ."Code : ".$e->getCode()."\n"
                ."Message : ".$e->getMessage()."\n"
                ."Trace : ".$e->getTraceAsString()

            );
        }


        return $fileName;
    }

    public function getUploadsDir(): string
    {
        return $this->uploadsDir;
    }

}