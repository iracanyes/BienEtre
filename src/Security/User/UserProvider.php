<?php
/**
 *
 * User: isk
 * Description: User Provider
 * Cette classe sera utilisé pour récupérer une entité en DB à partir des informations reçu dans une requête.
 * Date: 18.01.18
 * Time: 02:12
 */

namespace App\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use App\Entity\User;

class UserProvider implements UserProviderInterface
{

    public function loadUserByUsername($username)
    {
        $em = $this->getDoctrine()->getManager();

        $user= $em->getRepository("App:User")
            ->loadUserByUsername($username);

        if($user){

            return $user;

        }

        throw new UsernameNotFoundException(
            sprintf("L'utilisateur '%s' n'existe pas! ", $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        //Si ce n'est pas une instance de la classe User, on arrête l'exécution de la fct
        if(!$user instanceof User){
            throw new UnsupportedUserException("Cette instance de classe '%s' n'est pas supporté!", get_class($user));
        }

        return $this->loadUserByUsername($user->getUsername());


    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }

}