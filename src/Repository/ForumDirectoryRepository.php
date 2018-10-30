<?php

namespace App\Repository;

use App\Entity\ForumDirectory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ForumDirectory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForumDirectory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForumDirectory[]    findAll()
 * @method ForumDirectory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumDirectoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ForumDirectory::class);
    }

//    /**
//     * @return ForumDirectory[] Returns an array of ForumDirectory objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ForumDirectory
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
