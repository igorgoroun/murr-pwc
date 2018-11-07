<?php

namespace App\Repository;

use App\Entity\CVvote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CVvote|null find($id, $lockMode = null, $lockVersion = null)
 * @method CVvote|null findOneBy(array $criteria, array $orderBy = null)
 * @method CVvote[]    findAll()
 * @method CVvote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CVvoteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CVvote::class);
    }

//    /**
//     * @return CVvote[] Returns an array of CVvote objects
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
    public function findOneBySomeField($value): ?CVvote
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
