<?php

namespace App\Repository;

use App\Entity\ForumPost;
use App\Entity\ForumTopic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ForumPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForumPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForumPost[]    findAll()
 * @method ForumPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumPostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ForumPost::class);
    }

    public function findPaginated(ForumTopic $topic)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.topic = :topic')
            ->setParameter('topic', $topic)
            ->orderBy('p.created', 'ASC')
            ->getQuery();
    }

//    /**
//     * @return ForumPost[] Returns an array of ForumPost objects
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
    public function findOneBySomeField($value): ?ForumPost
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
