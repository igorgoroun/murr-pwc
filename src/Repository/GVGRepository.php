<?php

namespace App\Repository;

use App\Entity\GVG;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GVG|null find($id, $lockMode = null, $lockVersion = null)
 * @method GVG|null findOneBy(array $criteria, array $orderBy = null)
 * @method GVG[]    findAll()
 * @method GVG[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GVGRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GVG::class);
    }

//    /**
//     * @return GVG[] Returns an array of GVG objects
//     */

    public function findUpcoming()
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.date >= :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('g.date', 'ASC')
            ->orderBy('g.time', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?GVG
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
