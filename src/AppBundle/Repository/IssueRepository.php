<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * IssueRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IssueRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAll($page = 1, $limit = 100)
    {
        $query = $this->createQueryBuilder('i')
            ->getQuery();

        $paginator = $this->paginate($query, $page, $limit);

        return $paginator;
    }

    public function paginate($dql, $page = 1, $limit = 100)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }
}
