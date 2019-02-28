<?php

namespace App\Repository;

use App\Entity\HistoriqueService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HistoriqueService|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoriqueService|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoriqueService[]    findAll()
 * @method HistoriqueService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoriqueServiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HistoriqueService::class);
    }

    /**
    * @return HistoriqueService[] Returns an array of HistoriqueService objects
    */ 
    public function findById($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.service = :val')
            ->setParameter('val', $value)
            //->orderBy('h.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?HistoriqueService
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
