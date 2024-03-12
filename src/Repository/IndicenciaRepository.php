<?php

namespace App\Repository;

use App\Entity\Indicencia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Indicencia>
 *
 * @method Indicencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Indicencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Indicencia[]    findAll()
 * @method Indicencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndicenciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Indicencia::class);
    }

    //    /**
    //     * @return Indicencia[] Returns an array of Indicencia objects
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

    //    public function findOneBySomeField($value): ?Indicencia
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
