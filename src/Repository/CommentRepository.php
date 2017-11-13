<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 13.11.17
 * Time: 21:09
 */
namespace App\Repository;

use \Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function recentComments(): array
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('c')
            ->from($this->_entityName, 'c')
            ->orderBy('c.entryDate','DESC');

        return $qb->getQuery()->getResult();
    }
}