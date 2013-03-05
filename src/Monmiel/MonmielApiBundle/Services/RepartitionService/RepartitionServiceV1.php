<?php

namespace Monmiel\MonmielApiBundle\Services\FacilityService;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Event\NewDayEvent;

/**
 * @DI\Service("monmiel.repartition.service")
 */
class RepartitionServiceV1
{

    /**
     * @DI\Inject("monmiel.transformers.service")
     * @var \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1 $transformers
     */
    public $transformers;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Jour_DAO
     */
    public $dayRetrieved;

    public function setup()
    {
       $this->dayRetrieved =  $this->transformers->get(1);
    }


    /**
     * @param $dayNumber
     * @
     */

    private function  computeEstimateTedTargetDailyConsumption($dayNumber)

    {
        $coeffToUse =  2; //given


            //i retrieve a day
            $currentDay =$this->dayRetrieved;
            $current = $currentDay;
            $current->setQuarters(array());
            $currentDayQuarters = $currentDay->getgetQuarters();

            for ($j = 0; $j < sizeof($currentDayQuarters); $j++) {

                $currentQuarter = $currentDayQuarters[$j];
                $currentQuarter = $this->updateQuarter($currentQuarter, $coeffToUse);
                array_push($current, $currentQuarter);
            }





return current;

    }
}
