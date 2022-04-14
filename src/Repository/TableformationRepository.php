<?php

namespace App\Repository;

use App\Entity\Tableformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tableformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tableformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tableformation[]    findAll()
 * @method Tableformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tableformation::class);
    }

    // /**
    //  * @return Tableformation[] Returns an array of Tableformation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tableformation
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
