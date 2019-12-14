<?php

namespace App\Repository;

use App\Entity\GroupCompany;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GroupCompany|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupCompany|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupCompany[]    findAll()
 * @method GroupCompany[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupCompany::class);
    }

    public function totalGroupsOfClient($idClient)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.client = :val')
            ->setParameter('val', $idClient)
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function totalGroups()
    {
        return $this->createQueryBuilder('g')
            ->select('count(g)')
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
