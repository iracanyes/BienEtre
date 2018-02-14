<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 12.02.18
 * Time: 20:13
 */
namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFile extends Controller
{
    private const PATH = 'public/uploads';

    /**
     * @var string $filename
     */
    private $filename;

    /**
     * @var UploadedFile $file
     */
    private $file;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->filename = $this->generateUniqueFilename().".".$file->guessExtension();
    }

    public function upload():void
    {
        $this->file->move(self::PATH,$this->filename);


    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
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

    public function generateUniqueFilename(): string
    {
        // md5() => générer un chaîne unique
        // uniqid() => baser sur le timestamp
        return md5(uniqid());
    }

}