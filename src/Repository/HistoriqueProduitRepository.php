<?php

namespace App\Repository;

use App\Entity\HistoriqueProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HistoriqueProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoriqueProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoriqueProduit[]    findAll()
 * @method HistoriqueProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoriqueProduitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HistoriqueProduit::class);
    }

    /**
    * @return HistoriqueProduit[] Returns an array of HistoriqueProduit objects
    */
    public function findTrackProductById($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.produit = :val')
            ->setParameter('val', $value)
            // ->orderBy('h.id', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?HistoriqueProduit
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
