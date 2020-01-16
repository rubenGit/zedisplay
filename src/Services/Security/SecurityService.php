<?php
/**
 * Created by PhpStorm.
 * User: ruben
 * Date: 18/11/2019
 * Time: 15:56
 */

namespace App\Services\Security;


use App\Entity\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class SecurityService
{
    private $em;
    private $userRepository;
    private $passwordEncoder;

    /**
     * HomeQueryManager constructor.
     * @param $em
     */
    public function __construct(EntityManager $em, Security $security, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->userRepository = $this->em->getRepository(User::class);
        $this->passwordEncoder = $passwordEncoder;
    }

    public function ifNotExistPersist($nameClient, $companyName, $address, $city, $postalCode, $contactPersonPhone, $emailUser, $username, $plainPassword)
    {
       $user = $this->userRepository->findOneBy(['username'=>$username, 'email' =>$emailUser]);

        if($user)
        {
            return true;

        }else{
            $this->createUserAndClient($nameClient, $companyName, $address, $city, $postalCode, $contactPersonPhone, $emailUser, $username, $plainPassword);
            return false;
        }


    }

    public function createUserAndClient($nameClient, $companyName, $address, $city, $postalCode, $contactPersonPhone, $emailUser, $username, $plainPassword)
    {
        $newClient= new Client();
        $newClient->setNameClient($nameClient);
        $newClient->setCompanyName($companyName);
        $newClient->setCity($city);
        $newClient->setAddress($address);
        $newClient->setContactPersonPhone($contactPersonPhone);
        $newClient->setPostalCode($postalCode);
        try {
            $this->em->persist($newClient);
        } catch (ORMException $e) {
        }


        $newUser = new User();
        $newUser->setFullName($username);
        $newUser->setUsername($username);
        $newUser->setEmail($emailUser);
        $newUser->setPlainPassword( $plainPassword);
        $newUser->setPassword($this->passwordEncoder->encodePassword($newUser, $plainPassword));
        $newUser->setRoles(['ROLE_USER']);
        $newUser->setClient($newClient);
        try {
            $this->em->persist($newUser);
        } catch (ORMException $e) {
        }

        $this->em->flush();
    }

    public function getUser($username, $password)
    {
        return $this->userRepository->findOneBy(['username' => $username, 'password' => $password]);
    }
}