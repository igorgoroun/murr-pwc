<?php

namespace App\Repository;

use App\Entity\HomepageBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HomepageBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomepageBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomepageBlock[]    findAll()
 * @method HomepageBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomepageBlockRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HomepageBlock::class);
    }

//    /**
//     * @return HomepageBlock[] Returns an array of HomepageBlock objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HomepageBlock
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
