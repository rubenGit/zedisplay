<?php

namespace App\Controller\EasyAdmin;

use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\Client;
use App\Entity\Content;
use App\Entity\Device;
use App\Entity\Establishment;
use App\Entity\GroupCompany;
use App\Entity\User;
use App\Services\HomeQueryManager;

class AdminController extends EasyAdminController
{
    private $security;
    private $idClient;
    private $user;

    public function __construct(Security $security)
    {
        $this->security = $security;
        $this->idClient =  $this->security->getUser()->getClient();
        $this->user =  $this->security->getUser();
    }

    /**
     * @Route("/", name="easyadmin")
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }

    public function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $response = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);

        if(!$this->isGranted(User::ROLE_SUPER_ADMIN))  {
            switch ($entityClass) {
                case GroupCompany::class:
                    $response->Where('entity.client IN(:idClient)');
                    $response->setParameters([
                        'idClient' => $this->idClient
                    ]);
                    break;

                case Establishment::class:
                    $response->Where('entity.client IN(:idClient)');
                    $response->setParameters([
                        'idClient' => $this->idClient
                    ]);
                    break;

                case Device::class:
                    $response->Where('entity.client IN(:idClient)');
                    $response->setParameters([
                        'idClient' => $this->idClient
                    ]);
                    break;

                case Client::class:
                    $response->Where('entity.id IN(:idClient)');
                    $response->setParameters([
                        'idClient' => $this->idClient
                    ]);
                    break;

                case User::class:
                    $response->Where('entity.client IN(:idClient)');
                    $response->setParameters([
                        'idClient' => $this->idClient
                    ]);
                    break;

                case Content::class:
                    $response->Where('entity.client IN(:idClient)');
                    $response->setParameters([
                        'idClient' => $this->idClient
                    ]);
                    break;

            }
        }
        return $response;
    }

    /**
     * [***************************************************** filters according to the client *************************************************************]
     */
    protected function createNewForm($entity, array $entityProperties)
    {
        $form = parent::createNewForm($entity, $entityProperties);

        $this->getFiltersForms($entity, $form);

        return $form;
    }

    protected function createEditForm($entity, array $entityProperties){

        $form = parent::createEditForm($entity, $entityProperties);

        $this->getFiltersForms($entity, $form);

        return $form;
    }


    protected function getFiltersForms($entity, $form)
    {

        if(!$this->isGranted(User::ROLE_SUPER_ADMIN))  {

            if ($entity instanceof User) {

                $form->add('client', EntityType::class, array(
                    'class' => 'App:Client',
                    'query_builder' => function (EntityRepository $er)  {
                        return $er->createQueryBuilder('entity')
                            ->where("entity.id =:idUser")
                            ->setParameters([
                                'idUser' => $this->idClient
                            ]);
                    }
                ));

            }

            if ($entity instanceof Establishment) {

                $form->add('groupCompany', EntityType::class, array(
                    'class' => 'App:GroupCompany',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('entity')
                            ->where("entity.client IN(:idClient)")
                            ->setParameters([
                                'idClient' => $this->idClient
                            ])
                            ->orderBy('entity.client', 'ASC');
                    }
                ));

            }

            if ($entity instanceof Device) {
                $form->add('establishment', EntityType::class, array(
                    'class' => 'App:Establishment',
                    'query_builder' => function (EntityRepository $er)  {
                        return $er->createQueryBuilder('entity')
                            ->where("entity.client IN(:idClient)")
                            ->setParameters([
                                'idClient' => $this->idClient
                            ])
                            ->orderBy('entity.client', 'ASC');
                    }
                ));

                $form->add('contents', EntityType::class, array(
                    'class' => 'App:Content',
//                    'multiple' => 'true',
                    'query_builder' => function (EntityRepository $er)  {
                        return $er->createQueryBuilder('entity')
                            ->where("entity.client IN(:idClient)")
                            ->setParameters([
                                'idClient' => $this->idClient
                            ])
                            ->orderBy('entity.client', 'ASC');
                    }
                ));
            }
        }
    }
    /**
     * [***************************************************** filters according to the client *************************************************************]
     */



    public function createNewUserEntity()
    {

    }

    public function persistUserEntity($user)
    {
        // TODO: PERSIST NEW USER
    }

    public function updateUserEntity($user)
    {
        // TODO: UPDATE NEW USER
    }

    /**
     * @Route("/dashboard", name="dashboard")
     * @param Request $request
     * @return Response
     */
    public function dashboardAction(Request $request, HomeQueryManager $homeQueryManager)
    {
        return $this->render(
            'admin/easyadmin/dasbhboard.html.twig',
            [
                'totalUsers' => count($homeQueryManager->getTotalUsers()),
                'totalGroups' => count($homeQueryManager->getTotalGroups()),
                'totalEstablishments' =>  count($homeQueryManager->getTotalEstablishments()),
                'totalDevices' =>  count($homeQueryManager->getTotalDevice()),
                'totalContent' =>  count($homeQueryManager->getTotalContent())
            ]
        );
    }

    public function getEntityFormBuilder($entity, $view)
    {
        return $this->createEntityFormBuilder($entity, $view);
    }


    public function save($entity, $newForm)
    {
        $this->executeDynamicMethod('persist<EntityName>Entity', [$entity, $newForm]);
        $this->dispatch(EasyAdminEvents::POST_PERSIST, ['entity' => $entity]);
    }
}
