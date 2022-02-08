<?php

namespace App\Repository;

use App\Entity\KeyWord;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

     /**
      * @return Post[] Returns an array of Post objects
      */
    public function findLatestPublished(int $maxResults, int $offset)
    {
        return $this
            ->createQueryBuilder('post')
            ->addSelect('category')
            ->andWhere('post.createdAt <= CURRENT_DATE()')
            ->orderBy('post.createdAt', 'DESC')
            ->leftJoin('post.attachedTo', 'category')
            ->getQuery()
            ->setMaxResults($maxResults)
            ->setFirstResult($offset)
            ->getResult()
        ;
    }

    /**
     * @return Post[] Returns an array of Post objects
     */
    public function findLatestPublishedDQL(int $maxResults, int $offset)
    {
        return $this
            ->getEntityManager()->createQuery(
                'SELECT post, category FROM '.Post::class.' post '.
                'LEFT JOIN post.attachedTo category '.
                'WHERE post.createdAt <= CURRENT_DATE() '.
                'ORDER BY post.createdAt DESC'
            )
            ->setMaxResults($maxResults)
            ->setFirstResult($offset)
            ->getResult()
        ;
    }

    /**
     * @return Post[]
     */
    public function findHavingKeyword(KeyWord $keyWord)
    {
        return $this
            ->createQueryBuilder('post')
            ->join('post.keywords', 'keywords')
            ->andWhere(':keyword IN (keywords)')
            ->getQuery()
            ->setParameter('keyword', $keyWord)
            ->getResult()
        ;
    }
}
