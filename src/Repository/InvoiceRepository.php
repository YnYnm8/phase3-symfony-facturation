<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invoice>
 */
class InvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoice::class);
    }
// src/Repository/InvoiceRepository.php

public function countByMonth(\DateTime $date): int
{
    return $this->createQueryBuilder('i')
        ->select('COUNT(i.id)')
        ->where('i.created_at >= :start')
        ->andWhere('i.created_at <= :end')
        ->setParameter('start', new \DateTime($date->format('Y-m-01 00:00:00')))
        ->setParameter('end', new \DateTime($date->format('Y-m-t 23:59:59')))
        ->getQuery()
        ->getSingleScalarResult();
}
//    /**
//     * @return Invoice[] Returns an array of Invoice objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Invoice
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
