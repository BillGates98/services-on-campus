<?php

namespace App\Repository;

use App\Entity\Serivce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Serivce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serivce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serivce[]    findAll()
 * @method Serivce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerivceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Serivce::class);
    }

    // /**
    //  * @return Serivce[] Returns an array of Serivce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Serivce
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
