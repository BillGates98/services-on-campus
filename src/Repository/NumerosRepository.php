<?php

namespace App\Repository;

use App\Entity\Numeros;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Numeros|null find($id, $lockMode = null, $lockVersion = null)
 * @method Numeros|null findOneBy(array $criteria, array $orderBy = null)
 * @method Numeros[]    findAll()
 * @method Numeros[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumerosRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Numeros::class);
    }

    /**
    * @return Numeros[] Returns an array of Numeros objects
    */
    public function findAllNumbers($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.client = :val')
            ->setParameter('val', $value)
            // ->orderBy('n.id', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Numeros
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
