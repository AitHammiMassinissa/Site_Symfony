<?php

namespace App\Repository;

use App\Entity\CommandePayement;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommandePayement|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandePayement|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandePayement[]    findAll()
 * @method CommandePayement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandePayementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandePayement::class);
    }
    public function countSoldeOrder(User $user)
    {
        return $this->createQueryBuilder('o')
            ->select('sum(o.Prix)')
            ->andWhere('o.UserId = :UserId')
            ->setParameter('UserId', $user->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
    // /**
    //  * @return CommandePayement[] Returns an array of CommandePayement objects
    //  */
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
    public function findOneBySomeField($value): ?CommandePayement
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
