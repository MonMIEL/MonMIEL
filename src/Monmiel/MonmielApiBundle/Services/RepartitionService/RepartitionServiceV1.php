<?php

namespace Monmiel\MonmielApiBundle\Services\FacilityService;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Event\NewDayEvent;

/**
 * @DI\Service("monmiel.repartition.service")
 */
class RepartitionServiceV1 implements RepartitionServiceInterface
{


    /**
     * @DI\Inject("monmiel.transformers.service")
     * @var \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1 $transformers
     */
    public $transformers;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public $dayRetrieved;

    public function getReferenceDay($dayNumber)
    {
        $this->dayRetrieved = $this->transformers->get($dayNumber);
    }


    /**
     * Computes and updates a day value using
     * same repartition as reference year
     * @param $dayNumber
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */

    private function  computeEstimateTedTargetDailyConsumption($dayNumber)

    {
        $this->getReferenceDay($dayNumber);
        $coeffToUse = 2; //given


        //i retrieve a day
        $currentDay = $this->dayRetrieved;
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

    /**
     * @param $day integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function get($day)
    {

        return $this->computeEstimateTedTargetDailyConsumption($day);
    }
}
