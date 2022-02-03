<?php

namespace App\Repository;

use App\Entity\Tip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tip[]    findAll()
 * @method Tip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tip::class);
    }

    public function search($q){
        return $this->createQueryBuilder('t')
                    ->where('t.title LIKE :q')->setParameter('q', '%'.$q.'%')
                    ->orWhere('t.content LIKE :q')->setParameter('q', '%'.$q.'%')
                    ->andWhere('t.isValid = 1')
                    ->orderBy('t.id', 'DESC')
                    ->getQuery()
                    ->setMaxResults(10)
                    ->setFirstResult(0)
                    ->getResult()
        ;
    }

    public function tipByTag($tags, $skip, $fetch){
        $countTags = sizeof($tags);
        return $this->createQueryBuilder('tip')
                    ->join('tip.tag', 'tag')
                    ->where('tag.name in (:tags)')->setParameter('tags', $tags)
                    ->andWhere('tip.isValid = 1')
                    ->groupBy('tip.id')
                    ->having("count(tip) >= $countTags")
                    ->orderBy('tip.id', 'DESC')
                    ->setMaxResults($fetch)
                    ->setFirstResult($skip)
                    ->getQuery()
                    ->getResult()
        ;
    }
    // /**
    //  * @return Tip[] Returns an array of Tip objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tip
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
