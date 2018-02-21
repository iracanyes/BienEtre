<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 12.02.18
 * Time: 20:13
 */
namespace App\Service\Uploads;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class UploadFile
{
    /**
     * @var string
     */
    public static $path ;

    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var string
     */
    protected $filename;

    /**
     * UploadFile constructor.
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(string $path = "" )
    {
        self::$path = $path;
    }


    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file): void
    {
        // Fichier reçu
        $this->file = $file;


    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return void
     */
    public function upload(string $path = null):void
    {
        // Création d'un nom de fichier
        $this->filename = $this->generateUniqueFilename().".".$this->file->guessExtension();

        // Déplacement du fichier
        $this->file->move($path ?? self::$path ,$this->filename);

        unset($this->file);
    }

    public function generateUniqueFilename(): string
    {
        // md5() => générer un chaîne unique
        // uniqid() => baser sur le timestamp
        return sha1(uniqid());
    }


}