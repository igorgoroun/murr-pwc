<?php

namespace App\Repository;

use App\Entity\ForumDirectory;
use App\Entity\ForumPost;
use App\Entity\ForumTopic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
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

    public function findLatestForDir(ForumDirectory $directory)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.directory = :dir')
            ->setParameter('dir', $directory)
            ->orderBy('p.created', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findLatestForHome(int $qty = 5)
    {
        $posts = new ArrayCollection();
        $topics = $this->getEntityManager()->getRepository('App:ForumTopic')->findLatestForHome($qty);

        foreach ($topics as $topic) {
            $post = $this->createQueryBuilder('p')
                ->where('p.topic = :topic')
                ->orderBy('p.modified', 'DESC')
                ->orderBy('p.created', 'DESC')
                ->setMaxResults(1)
                ->setParameter('topic', $topic)
                ->getQuery()->getOneOrNullResult();
            if ($post) {
                $posts->add($post);
            }
        }

        return $posts;
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
