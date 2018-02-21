<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.02.18
 * Time: 03:19
 */
namespace App\Service\Uploads;

use App\Service\Uploads\UploadFile;

use App\Entity\Client;
use App\Entity\Provider;
use App\Entity\ServiceCategory;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UploadImages
{
    /**
     * @var string
     */
    public static $path ;

    /**
     * @var Client|Provider|ServiceCategory
     */
    private $entity;

    /**
     * @var UploadFile
     */
    private $uploader;

    public function __construct(LifecycleEventArgs $args, UploadFile $uploader = null, string $path = "")
    {
        $this->uploader = $uploader;

        $this->entity = $args->getEntity();

        self::$path = $path;
    }

    /**
     * @return Client|Provider|ServiceCategory
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param Client|Provider|ServiceCategory $entity
     */
    public function setEntity($entity): void
    {
        $this->entity = $entity;
    }

    /**
     * @return \App\Service\Uploads\UploadFile
     */
    public function getUploader(): UploadFile
    {
        return $this->uploader;
    }

    /**
     * @param \App\Service\Uploads\UploadFile $uploader
     */
    public function setUploader(UploadFile $uploader): void
    {
        $this->uploader = $uploader;
    }



    public function uploadAvatar(): void
    {
        // Seul les clients ont un avatar
        if(!$this->entity instanceof Client){
            return;
        }

        //Chargement de l'image
        $this->uploader->setFile($this->entity->getAvatar()->getUrl());

        // Déplacement du fichier dans le répertoire des images uploadé + création nom unique
        $this->uploader->upload();

        // Définition du nouveau nom de fichier
        $this->entity->getAvatar()->setUrl($this->uploader->getFilename());
    }

    public function uploadImage(): void
    {
        // Seul les clients ont un avatar
        if(!$this->entity instanceof ServiceCategory){
            return;
        }

        //Chargement de l'image
        $this->uploader->setFile($this->entity->getImage()->getUrl());

        // Déplacement du fichier dans le répertoire des images uploadé et création d'un id unique
        $this->uploader->upload();

        // Définition du nouveau nom de fichier
        $this->entity->getImage()->setUrl($this->uploader->getFilename());
    }

    public function uploadLogos(): void
    {
        if(!$this->entity instanceof Provider){
            return;
        }

        foreach ($this->entity->getLogos() as $logo) {
            //Chargement de l'image
            $this->uploader->setFile($logo->getUrl());
            // Déplacement du fichier dans le répertoire des images uploadé et création d'un id unique
            $this->uploader->upload(self::$path);
            // Définition du nouveau nom de fichier
            $logo->setUrl($this->uploader->getFilename());

            $this->entity->addLogo($logo);
        }
    }

    public function uploadImages(): void
    {
        if(!$this->entity instanceof Provider){
            return;
        }

        foreach ($this->entity->getImages() as $logo) {
            $this->uploader->setFile($logo);
            // Déplacement du fichier dans le répertoire des images uploadé et création d'un id unique
            $this->uploader->upload(self::$path);
            // Définition du nouveau nom de fichier
            $logo->setUrl($this->uploader->getFilename());

            // Ajout de l'image à la collection
            $this->entity->addImage($logo);
        }


    }


}