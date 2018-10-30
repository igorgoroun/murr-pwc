<?php

namespace App\Repository;

use App\Entity\CharSide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CharSide|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharSide|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharSide[]    findAll()
 * @method CharSide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharSideRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CharSide::class);
    }

//    /**
//     * @return CharSide[] Returns an array of CharSide objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CharSide
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
