<?php

namespace App\Repository;

use App\Entity\Conference;
use App\Entity\Establishment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Conference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conference[]    findAll()
 * @method Conference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conference::class);
    }

    // /**
    //  * @return Conference[] Returns an array of Conference objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findByEstablishment(int $id): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.establishment = :id')
            ->setParameter('id', $id)
            ->orderBy('c.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getSearchQuery(Establishment $establishment): QueryBuilder
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.establishment = :id')
            ->setParameter('id', $establishment->getId());
    }

    public function getAllApproved(): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.isShared = :shared')
            ->setParameter('shared', true);
    }
}
