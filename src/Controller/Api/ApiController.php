<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\DeviceRepository;
use App\Repository\EstablishmentRepository;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{

    /**
     * @var DeviceRepository
     */
    private $deviceRepository;
    /**
     * @var EstablishmentRepository
     */
    private $establishmentRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ParameterBagInterface
     */
    private $params;


    public function __construct(
        EstablishmentRepository $establishmentRepository,
        DeviceRepository $deviceRepository,
        SerializerInterface $serializer,
        ParameterBagInterface $params
    ) {
        $this->deviceRepository = $deviceRepository;
        $this->establishmentRepository = $establishmentRepository;
        $this->params = $params;
        $this->serializer = $serializer;
    }

    private function serialize($data, $format = 'json')
    {
        return $this->serializer->serialize($data, $format,['json_encode_options' => JSON_UNESCAPED_SLASHES]);

    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function getUrltoLoadAction(Request $request)
    {
        $uuid = $request->get('uuid');

        if (!$device = $uuid ) {
            return new Response('UUID - INDENTIFIER not sent', Response::HTTP_NOT_FOUND);
        }

        $device = $this->deviceRepository->findOneBy(['id' => $uuid]);

        $result['stream'] = [
            'state' => '404',
            'info' => 'Not Found'
        ];

        if($device)
        {
            $result['stream'] = [
                'state' => '200',
                'info' => 'OK',
                'url' => $device->getContent()->getUrl(),
                'image' => $this->params->get('app.path.product_images').'/'. $device->getContent()->getImage()
            ];
        }

        $response = new Response(
            $this->serialize($result),
            Response::HTTP_OK
        );

        return $response;
    }

}
