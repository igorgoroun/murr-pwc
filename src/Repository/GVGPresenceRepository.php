<?php

namespace App\Repository;

use App\Entity\GVGPresence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GVGPresence|null find($id, $lockMode = null, $lockVersion = null)
 * @method GVGPresence|null findOneBy(array $criteria, array $orderBy = null)
 * @method GVGPresence[]    findAll()
 * @method GVGPresence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GVGPresenceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GVGPresence::class);
    }

//    /**
//     * @return GVGPresence[] Returns an array of GVGPresence objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GVGPresence
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
