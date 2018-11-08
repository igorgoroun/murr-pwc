<?php

namespace App\Repository;

use App\Entity\GVGParty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GVGParty|null find($id, $lockMode = null, $lockVersion = null)
 * @method GVGParty|null findOneBy(array $criteria, array $orderBy = null)
 * @method GVGParty[]    findAll()
 * @method GVGParty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GVGPartyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GVGParty::class);
    }

//    /**
//     * @return GVGParty[] Returns an array of GVGParty objects
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
    public function findOneBySomeField($value): ?GVGParty
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
