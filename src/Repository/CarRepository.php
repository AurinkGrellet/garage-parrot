<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function findAllOrderBy($field, $order): array
    {
        return $this->createQueryBuilder('c')
                ->orderBy('f.'.$field, $order)
                ->getQuery()
                ->getResult();
    }

    /**
     * @return Car[] Returns an array of Car objects
     */
    public function filterByField($field, $value, $comparator): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.'.$field.' '.$comparator.' :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Car[] Returns an array of Car objects
     */
    public function filterByFieldBetween($field, $valuelow, $valuehigh): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.'.$field.' >= :valmin')
            ->andWhere('c.'.$field.' <= :valmax')
            ->setParameter('valmin', $valuelow)
            ->setParameter('valmax', $valuehigh)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Car
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
