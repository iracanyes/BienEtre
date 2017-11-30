<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 12.11.17
 * Time: 20:01
 */


namespace App\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class HomeRepository extends EntityRepository
{
    protected function addJoins($qb)
    {
        $qb->join(Service::class, 's')
            ->join(Promotion::class, 'promo')
            ->join(Image::class, 'i');

        return $qb;
    }

    public function findWithJoins():array
    {
        $qb = $this->createQueryBuilder('p');

        $this->addJoins($qb);

        return $qb->getQuery()
            ->getResult();

    }
}