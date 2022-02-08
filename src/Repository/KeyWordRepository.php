<?php

namespace App\Repository;

use App\Entity\KeyWord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KeyWord|null find($id, $lockMode = null, $lockVersion = null)
 * @method KeyWord|null findOneBy(array $criteria, array $orderBy = null)
 * @method KeyWord[]    findAll()
 * @method KeyWord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeyWordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KeyWord::class);
    }

    // /**
    //  * @return KeyWord[] Returns an array of KeyWord objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KeyWord
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
