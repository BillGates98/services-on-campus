<?php

namespace App\Repository;

use App\Entity\Categories0;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Categories0|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories0|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories0[]    findAll()
 * @method Categories0[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Categories0Repository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Categories0::class);
    }

    // /**
    //  * @return Categories0[] Returns an array of Categories0 objects
    // */
    // public function findProductsOfCatById($value)
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.id = :val')
    //         ->setParameter('val', $value)
    //          ->orderBy('c.id', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    /*
    public function findOneBySomeField($value): ?Categories0
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
