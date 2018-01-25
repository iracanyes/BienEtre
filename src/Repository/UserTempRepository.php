<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 14.01.18
 * Time: 21:25
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use App\Entity\UserTemp;
class UserTempRepository extends EntityRepository
{
    /**
     * @param string $token
     * @return UserTemp|null
     */
    public function loadUserByToken(string $token)
    {
        return $this->_em->createQueryBuilder('u')
            ->where("u.token = :token")
            ->setParameter("token", $token)
            ->getQuery()
            ->getOneOrNullResult();
    }
}