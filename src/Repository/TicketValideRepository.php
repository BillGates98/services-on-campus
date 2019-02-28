<?php

namespace App\Repository;

use App\Entity\TicketValide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TicketValide|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketValide|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketValide[]    findAll()
 * @method TicketValide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketValideRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketValide::class);
    }

    // /**
    //  * @return TicketValide[] Returns an array of TicketValide objects
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
    public function findOneBySomeField($value): ?TicketValide
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
