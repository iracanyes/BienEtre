<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 18.01.18
 * Time: 01:01
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    /**
     * @param string $email
     * @return null|\Symfony\Component\Security\Core\User\UserInterface
     */
    public function loadUserByUsername($email)
    {
        return $this->createQueryBuilder('u')
            ->where("u.email = :email")
            ->setParameter("username", $email)
            ->getQuery()
            ->getOneOrNullResult();
    }


}