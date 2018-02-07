<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 17.10.17
 * Time: 13:59
 */

namespace App\DoctrineListener;

/*
 * Un objet type LifecycleEventArgs est transmis lorsque un événement Doctrine est déclenché(PostPersist/PostRemove)
 * Il contient l'entité sur lequel l'événement est déclenché.
 * Il retourne aussi l'entity_manager nécessaire pour la manipulation de l'entité.
 */
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Email\UserMailer;
use App\Entity\UserTemp;

class UserConfirmationListener
{
    /**
     * @var UserMailer
     */
    private $userMailer;

    public function __construct(UserMailer $userMailer)
    {
        $this->userMailer = $userMailer;
    }

    /**
     *
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $user = $args->getObject();

        if(!$user instanceof UserTemp){
            return;
        }

        $this->userMailer->sendConfirmation($user);
    }
}