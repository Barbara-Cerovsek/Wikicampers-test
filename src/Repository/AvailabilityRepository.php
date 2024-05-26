<?php

namespace App\Repository;

use App\Entity\Availability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Availability>
 */
class AvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Availability::class);
    }
    public function findVehicleByDate($start_date, $end_date)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a', 'v')
            ->join('a.vehicle', 'v')
            ->where('a.start_date <= :start_date')
            ->andWhere('a.end_date >= :end_date')
            ->setParameter('start_date', $start_date)
            ->setParameter('end_date', $end_date);
           
        return $qb;
                
        
    }
}

    //    public function findOneBySomeField($value): ?Availability
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

