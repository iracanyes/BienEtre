<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 15.02.18
 * Time: 17:59
 */

namespace App\DoctrineListener;

use App\Entity\Provider;
use App\Entity\Client;
use App\Entity\ServiceCategory;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Service\Uploads\UploadImages;
use App\Service\Uploads\UploadFile;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UploadImagesSubscriber implements EventSubscriber
{


    public function getSubscribedEvents():array
    {
        return array("postPersist","postUpdate");
    }

    public function postPersist(LifecycleEventArgs $args):void
    {
        if(!($this->isProvider($args) | $this->isClient($args) | $this->isServiceCategory($args))){
            return;
        }

        $this->upload($args, new UploadFile());
    }

    public function postUpdate(LifecycleEventArgs $args):void
    {
        if(!($this->isProvider($args) | $this->isClient($args) | $this->isServiceCategory($args))){
            return;
        }

        $this->upload($args, new UploadFile());
    }

    public function upload(LifecycleEventArgs $args, UploadFile $uploader):void
    {
        $entity = $args->getEntity();

        $em = $args->getEntityManager();

        $imagesUploader = new UploadImages($args);


        switch (get_class($entity)){
            case "Provider":

                $imagesUploader->uploadLogos();

                if(count($entity->getImages()) > 0){

                    $imagesUploader->uploadImages();
                }

                break;

            case "Client":

                $imagesUploader->uploadAvatar();

                break;

            case "ServiceCategory":

                $imagesUploader->uploadImage();

                break;
            default:

                return;

                break;
        }

        dump($entity);
        die();

        // Enregistrement des nouveaux noms de fichiers dans la base de données
        $em->persist($entity);
        $em->flush();

    }

    public function isProvider(LifecycleEventArgs $args){
        return $args->getEntity() instanceof Provider;
    }

    public function isClient(LifecycleEventArgs $args){
        return $args->getEntity() instanceof Client;
    }

    public function isServiceCategory(LifecycleEventArgs $args){
        return $args->getEntity() instanceof ServiceCategory;
    }

}