<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * This custom Doctrine repository is empty because so far we don't need any custom
 * method to query for application user information. But it's always a good practice
 * to define a custom repository that will be used when the application grows.
 *
 * See https://symfony.com/doc/current/doctrine/repository.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function totalUsersOfClient($idClient)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.client = :val AND u.enabled = :enabled')
            ->setParameters(['val'=> $idClient, 'enabled'=>true])
            ->getQuery()
            ->getResult()
            ;
    }

    public function totalUsers()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.enabled = :enabled')
            ->setParameters(['enabled'=>true])
            ->getQuery()
            ->getResult()
            ;
    }
    
    public function loadUserByUsername($usernameOrEmail)
    {
        return $this->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.username = :query
                OR u.email = :query'
        )
            ->setParameter('query', $usernameOrEmail)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
