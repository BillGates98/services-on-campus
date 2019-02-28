<?php

namespace App\Repository;

use App\Entity\Admin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Admin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Admin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Admin[]    findAll()
 * @method Admin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Admin::class);
    }

    // /**
    //  * @return Admin[] Returns an array of Admin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    // public function findOneOwn($id)
    // {
    //     $conn = $this->getEntityManager()->getConnection();
    //     $sql = '
    //         SELECT * FROM admin a WHERE a.service_id IN (
    //                 SELECT id FROM service s WHERE a.id = :id
    //             ) 
    //         ';
    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute(["id"=>$id]);

    //     return $stmt->fetchAll();

    // }

    // public function findAllOwn(): array
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         'SELECT a
    //         FROM App\Entity\Admin a
    //         WHERE a.id > 0
    //         ORDER BY a.id ASC'
    //     );
    //     //->setParameter('price', $price);

    //     // returns an array of Product objects
    //     return $query->execute();
    // }

    /*
    public function findOneBySomeField($value): ?Admin
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
