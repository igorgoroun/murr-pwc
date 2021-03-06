<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */

    public function findPaginated($role = false, $excluded = 0)
    {
        $qb = $this->createQueryBuilder('a');
        //select(['u','c.id as charClass', 't.id as partyRole', 'r.id as roleId'])
        $qb->select('a', 'c as char_class')
            //->from('App:User', 'u')
            ->leftJoin('a.charClass', 'c', 'WITH', 'c.id=a.charClass')
            ->leftJoin('c.partyRole', 't', 'WITH', 't.id=c.partyRole')
            ->leftJoin('a.userRole', 'r', 'WITH', 'r.id=a.userRole')
            ->where('a.excluded = :exclude')
            ->setParameter('exclude', $excluded)
        ;
        if ($role) {
            $group = $this->getEntityManager()->getRepository('App:UserGroup')->findOneBy(['role' => $role]);
            if ($group) {
                if (in_array($role, ['ROLE_GUEST', 'ROLE_USER'])) {
                    $qb->andWhere('a.userRole = :group_id');
                } else {
                    $qb->andWhere('a.userRole >= :group_id');
                }
                $qb->setParameter('group_id', $group->getId());
            }
        }

        $query = $qb->getQuery();
        return $query;
    }


    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
