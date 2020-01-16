<?php

namespace App\Repository;

use App\Entity\Channel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Channel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Channel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Channel[]    findAll()
 * @method Channel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChannelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Channel::class);
    }

    public function totalChannelOfClient($idClient)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.client = :val')
            ->setParameter('val', $idClient)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
