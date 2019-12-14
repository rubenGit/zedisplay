<?php

namespace App\Repository;

use App\Entity\Establishment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Establishment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Establishment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Establishment[]    findAll()
 * @method Establishment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstablishmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Establishment::class);
    }

    public function totalEstablishmentOfClient($idClient)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.client = :val')
            ->setParameter('val', $idClient)
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function totalEstablishments()
    {
        return $this->createQueryBuilder('e')
            ->select('count(e)')
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
