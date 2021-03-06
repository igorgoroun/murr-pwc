<?php

namespace App\Repository;

use App\Entity\CharClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CharClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharClass[]    findAll()
 * @method CharClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharClassRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CharClass::class);
    }

//    /**
//     * @return CharClass[] Returns an array of CharClass objects
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
    public function findOneBySomeField($value): ?CharClass
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
