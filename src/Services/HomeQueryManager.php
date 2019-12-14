<?php
/**
 * Created by PhpStorm.
 * User: ruben
 * Date: 18/11/2019
 * Time: 15:56
 */

namespace App\Services;


use Doctrine\ORM\EntityManager;
use App\Entity\Content;
use App\Entity\Device;
use App\Entity\Establishment;
use App\Entity\GroupCompany;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class HomeQueryManager
{
    private $em;
    private $contentRespository;
    private $deviceRepository;
    private $establishmentRepository;
    private $groupRepository;
    private $userRepository;
    private $isSuperAdminSupreme;
    private $idClient;

    /**
     * HomeQueryManager constructor.
     * @param $em
     */
    public function __construct(EntityManager $em, Security $security)
    {
        $this->em = $em;
        $this->contentRespository = $this->em->getRepository(Content::class);
        $this->deviceRepository = $this->em->getRepository(Device::class);
        $this->establishmentRepository = $this->em->getRepository(Establishment::class);
        $this->groupRepository = $this->em->getRepository(GroupCompany::class);
        $this->userRepository = $this->em->getRepository(User::class);
        $this->isSuperAdminSupreme = $security->getUser()->getSuperAdminSupreme();
        $this->idClient =  $security->getUser()->getClient();
    }

    public function getTotalContent(){

        $totalDevices = $this->contentRespository->totalContentOfClient($this->idClient);;

        if($this->isSuperAdminSupreme)
            $totalDevices = $this->contentRespository->findAll();

        return  $totalDevices;
    }

    public function getTotalDevice(){

        $totalDevices = $this->deviceRepository->totalDevicesOfClient($this->idClient);;

        if($this->isSuperAdminSupreme)
            $totalDevices = $this->deviceRepository->findAll();

        return  $totalDevices;
    }

    public function getTotalEstablishments(){

        $totalEstablishments = $this->establishmentRepository->totalEstablishmentOfClient($this->idClient);

        if($this->isSuperAdminSupreme)
            $totalEstablishments = $this->establishmentRepository->findAll();

        return $totalEstablishments;
    }

    public function getTotalGroups(){

        $totalGroups = $this->groupRepository->totalGroupsOfClient($this->idClient);

        if($this->isSuperAdminSupreme)
            $totalGroups = $this->groupRepository->findAll();

        return $totalGroups;

    }
    public function getTotalUsers(){

        $totalUsers = $this->userRepository->totalUsersOfClient($this->idClient);

        if($this->isSuperAdminSupreme)
            $totalUsers = $this->userRepository->findAll();

        return $totalUsers;

    }

}