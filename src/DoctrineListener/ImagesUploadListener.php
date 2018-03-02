<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 24.02.18
 * Time: 06:08
 */

namespace App\DoctrineListener;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\Provider;
use App\Entity\Client;
use App\Entity\ServiceCategory;
use App\Service\Uploads\FileUploader;
use App\Entity\Image;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ImagesUploadListener
{
    /**
     * @var FileUploader
     */
    private $uploader;

    /**
     * ImagesUploadListener constructor.
     * @param FileUploader $uploader
     */
    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args):void
    {
        $entity = $args->getEntity();

        $this->uploadImage($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args):void
    {
        $entity = $args->getEntity();


        $this->uploadImage($entity);
    }

    public function uploadImage($entity)
    {
        dump($entity);

        dump(!($entity instanceof Image));

        if(!($entity instanceof Image)){

            return;

        }

        $file = $entity->getUrl();


        preg_match("/\/(.*)\/(.*)/", $file, $result);

        // Bloque le développement tester à la fin
        $file = new UploadedFile($result[0],$result[2]);


        dump($file instanceof UploadedFile);
        dump($file);

        if($file instanceof UploadedFile){

            $fileName = $this->uploader->upload($file);

            //l'accès au fichier temporaire est refusé mais le fichier est trouvé
            dump($this->uploader->upload($file));

            $entity->setUrl($fileName);
        }
    }


    /**
     * @param LifecycleEventArgs $args
     */
    /* Activer la méthode après avoir supprimé les fixtures d'images provennant de lorempixel.com
        Ne pas oublier de décommenter la ligne concernant cette événement dans service.yaml
    public function postLoad(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if($entity instanceof Image){
            $entity->setUrl(new File($this->uploader->getUploadsDir().$entity->getUrl()));
        }
    }
    */
}