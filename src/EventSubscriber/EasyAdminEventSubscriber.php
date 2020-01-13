<?php
/**
 * Created by PhpStorm.
 * User: ruben
 * Date: 03/12/2019
 * Time: 18:17
 */

namespace App\EventSubscriber;


use App\Entity\Channel;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use App\Entity\Content;
use App\Entity\Device;
use App\Entity\Establishment;
use App\Entity\GroupCompany;

class EasyAdminEventSubscriber implements EventSubscriberInterface
{
    private $em;
    private $security;
    private $passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->em = $entityManager;
        $this->security = $security;
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::POST_PERSIST => ['newEvent'],
            EasyAdminEvents::POST_UPDATE => ['updateEvent'],

        ];
    }

    public function newEvent(GenericEvent $event)
    {
        return $this->persistEvent($event, 'NEW');
    }
    public function updateEvent(GenericEvent $event)
    {
        return $this->persistEvent($event, 'UPDATE');
    }

    private function persistEvent(
        GenericEvent $event, $action
    )
    {
        $entity = $event->getSubject();

        switch($entity) {
            case $entity instanceof User:
           // $this->setPassword($entity);
            break;
            case $entity instanceof GroupCompany:
            case $entity instanceof Establishment:
            case $entity instanceof Device:
            case $entity instanceof Channel:
            case $entity instanceof Content:
            $this->persisClientInSession($entity);
            break;
        }
    }

    private function setPassword(User $user)
    {
       $plainPass = $user->getPlainPassword();

       $passEncripted = $this->passwordEncoder->encodePassword($user, $plainPass);

       $user->setPassword($passEncripted);

       $this->em->persist($user);
    }


    private function persisClientInSession($entity)
    {
        $clientInSession = $this->security->getUser()->getClient();

        if ($this->security->isGranted(User::ROLE_SUPER_ADMIN)) {
            $this->keepClientAssociated($entity);
        }else{
            $this->addClientInSession($clientInSession, $entity);
        }

        $this->em->flush();
    }

    private function keepClientAssociated($entity)
    {
        $clientofCustomer = $entity->getClient();
        $entity->setClient($clientofCustomer);
        $this->em->persist($entity);
    }

    private function addClientInSession($client ,$entity)
    {
        $entity->setClient($client);
        $this->em->persist($entity);
    }

}