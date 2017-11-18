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
    public function recentPromotions(): array
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('p')
            ->from($this->_entityName, 'p')
            ->orderBy('p.releaseDate','DESC');

        return $queryBuilder->getQuery()
            ->getResult();
    }

    public function recentPromotionsPlusProviders(): array
    {
        $queryBuilder  = $this->_em->createQueryBuilder()
            ->select('p')
            ->from($this->_entityName, 'p')
            ->innerJoin("p.provider","prov")
            ->addSelect("prov")
            ->orderBy('p.releaseDate','DESC');

        return $queryBuilder->getQuery()
            ->getResult();
    }

    public function expiringPromotions(): array
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('p')
            ->from($this->_entityName, 'p')
            ->where('p.expiryDate > :expiryDate')
            ->setParameter('expiryDate' , date("Y-m-d H:i:s"))
            ->orderBy('p.expiryDate','ASC')
            ->setMaxResults(3);

        return $qb->getQuery()->getResult();
    }
}
