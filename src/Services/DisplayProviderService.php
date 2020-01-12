<?php
/**
 * Created by PhpStorm.
 * User: ruben
 * Date: 18/11/2019
 * Time: 15:56
 */

namespace App\Services;


use Doctrine\ORM\EntityManager;
use App\Entity\Device;
use Symfony\Component\Security\Core\Security;

class DisplayProviderService
{
    private $em;
    private $deviceRepository;


    /**
     * HomeQueryManager constructor.
     * @param $em
     */
    public function __construct(EntityManager $em, Security $security)
    {
        $this->em = $em;
        $this->deviceRepository = $this->em->getRepository(Device::class);
    }

    public function getChannelsOfDevice($uuid){

        $device = $this->deviceRepository->findOneBy(['id'=>$uuid]);

       // dump($device); die();

        return $device->getChannels();

    }


    public function generateContentForDevice($channels){

        //TODO: GET UUID

        //TODO: GENERATE QUERY WITH LIST

        $startList = "#EXTM3U";
        $baseChannel = '#EXTINF:-1,';
        $titleChannel = 'Canal';
        $headerChannel = $baseChannel . $titleChannel;

//        $channel1 = ['https://www.youtube.com/watch?v=1RwMFNy8UdM', 'https://www.youtube.com/watch?v=_iCETXJFhO8'];
//        $channel2 = ['https://www.youtube.com/watch?v=7fvHStnxT6k', 'https://www.youtube.com/watch?v=UR0La7_koW4'];
//        $channel3 = ['https://www.youtube.com/watch?v=tzviFoVfwFo', 'https://www.youtube.com/watch?v=-pitqeSUPX4'];
//        $channel4 = ['https://www.bioenciclopedia.com/wp-content/uploads/2016/07/caballo.jpg'];
        // $listChannels = [$channel1, $channel2, $channel3, $channel4];

        $listChannels = $channels;

        $dinamicData = "";
        $indexMainLoop = 1;

        foreach ($listChannels as $channel) {
            $indexMainLoop ++;

            foreach ($channel->getContents() as $content) {
                $dinamicData .= $headerChannel.' '.$indexMainLoop.'
              '.$content->getUrl().'
               ';
            }
        }

        $resultData = $startList.'
        '.$dinamicData;

        return $resultData;
    }

}