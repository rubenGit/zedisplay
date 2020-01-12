<?php

namespace App\Controller\Display;

use App\Services\DisplayProviderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GDisplayProviderController
 * @package App\Controller\Display
 *
 * TODO: Example to display
#EXTM3U
#EXTINF:-1,Canal 1 (youtube)
https://www.youtube.com/watch?v=1RwMFNy8UdM
#EXTINF:-1,Canal 1 (youtube)
https://www.youtube.com/watch?v=_iCETXJFhO8
#EXTINF:-1,Canal 2 (youtube)
https://www.youtube.com/watch?v=7fvHStnxT6k
#EXTINF:-1,Canal 2 (youtube)
https://www.youtube.com/watch?v=UR0La7_koW4
#EXTINF:-1,Canal 3 (youtube)
https://www.youtube.com/watch?v=tzviFoVfwFo
#EXTINF:-1,Canal 3 (youtube)
https://www.youtube.com/watch?v=-pitqeSUPX4
#EXTINF:-1,Canal 4 (imagen)
https://www.bioenciclopedia.com/wp-content/uploads/2016/07/caballo.jpg
 *
 */
class GDisplayProviderController extends AbstractController
{
    /**
     * @Route("/raw/{uuid}", name="generate_display_list")
     */
    public function generateDisplayList(Request $request, DisplayProviderService $displayProviderService, $uuid): Response
    {
        $channels = $displayProviderService->getChannelsOfDevice($uuid);

        $resultData = $displayProviderService->generateContentForDevice($channels);

        $response = new Response(
            $resultData,
            Response::HTTP_OK,
            ['content-type' => 'text/plain']
        );

        return $response;
    }
}
