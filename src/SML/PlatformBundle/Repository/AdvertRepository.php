<?php

namespace SML\PlatformBundle\Repository;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends \Doctrine\ORM\EntityRepository
{
    public function myFindAll()
    {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getResult();
    }


    public function myFindOne($id)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('a.id = : id')
            ->setParameter('id', $id);

        return $qb->getQuery()
            ->getResult();
    }

    public function findByAuthorAndDate($author, $year)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('a.author = :author')
            ->setParameter('author', $author)
            ->andWhere('a.date < :year')
            ->setParameter('year', $year)
            ->orderBy('a.date', 'DESC');

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function whereCurrentYear(QueryBuilder $qb)
    {
        $qb
            ->andWhere('a.date BETWEEN :start AND :end')
            ->setParameter('start', new \Datetime(date('Y').'-01-01'))  // Date entre le 1er janvier de cette année
            ->setParameter('end',   new \Datetime(date('Y').'-12-31'));  // Et le 31 décembre de cette année;
    }


    public function getAdvertWithCategories(array $categoryNames)
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.categories', 'c')
            ->addSelect('c');

        $qb->where($qb->expr()->in('c.name', $categoryNames));

        return $qb->getQuery()->getResult();
    }


    public function getAdvertWithApplications()
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->innerJoin('a.applications', 'app')
            ->addSelect('app');

        return $qb
            ->getQuery()
            ->getResult();
    }
}
