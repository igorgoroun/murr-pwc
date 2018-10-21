<?php

namespace App\Repository;

use App\Entity\PartyRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PartyRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartyRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartyRole[]    findAll()
 * @method PartyRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyRoleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PartyRole::class);
    }

//    /**
//     * @return PartyRole[] Returns an array of PartyRole objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PartyRole
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
