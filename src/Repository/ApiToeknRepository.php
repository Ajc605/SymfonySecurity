<?php

namespace App\Repository;

use App\Entity\ApiToekn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ApiToekn|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiToekn|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiToekn[]    findAll()
 * @method ApiToekn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiToeknRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiToekn::class);
    }

    // /**
    //  * @return ApiToekn[] Returns an array of ApiToekn objects
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

    /*
    public function findOneBySomeField($value): ?ApiToekn
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
