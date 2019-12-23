<?php

namespace App\Controller\Display;

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
     * @Route("/raw/123", name="generate_display_list")
     */
    public function generateDisplayList(Request $request): Response
    {
        //TODO: GET UUID

        //TODO: GENERATE QUERY WITH LIST

        $startList = "#EXTM3U";
        $baseChannel = '#EXTINF:-1,';
        $titleChannel = 'Canal';
        $headerChannel = $baseChannel . $titleChannel;

        $channel1 = ['https://www.youtube.com/watch?v=1RwMFNy8UdM', 'https://www.youtube.com/watch?v=_iCETXJFhO8'];
        $channel2 = ['https://www.youtube.com/watch?v=7fvHStnxT6k', 'https://www.youtube.com/watch?v=UR0La7_koW4'];
        $channel3 = ['https://www.youtube.com/watch?v=tzviFoVfwFo', 'https://www.youtube.com/watch?v=-pitqeSUPX4'];
        $channel4 = ['https://www.bioenciclopedia.com/wp-content/uploads/2016/07/caballo.jpg'];

        $listChannels = [$channel1, $channel2, $channel3, $channel4];

        $content = $this->render('gdisplay_provider/index.html.twig', [
            'start_list' => $startList,
            'header_channel' => $headerChannel,
            'list_channels' => $listChannels
        ]);


        $response = new Response(
            '#EXTM3U
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
https://www.bioenciclopedia.com/wp-content/uploads/2016/07/caballo.jpg',
            Response::HTTP_OK,
            ['content-type' => 'text/plain']
        );

        return $response;



    }

}
