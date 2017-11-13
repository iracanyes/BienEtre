<?php

namespace App\Repository;

/**
 * PromotionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PromotionRepository extends \Doctrine\ORM\EntityRepository
{
    public function recentPromotions(): Array
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('p')
            ->from($this->_entityName, 'p')
            ->orderBy('p.startDate','DESC');

        return $queryBuilder->getQuery()
            ->getResult();
    }
}
