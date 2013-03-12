<?php

namespace Monmiel\MonmielApiBundle\Tests\Services\FacilityService;

use Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService;
use Monmiel\MonmielApiModelBundle\Model\Parc\ParcFinal;
use Monmiel\MonmielApiBundle\Tests\BaseTestCase;

class ComputeFacilityServiceTest extends BaseTestCase
{
    /**
     * @var $facilityService ComputeFacilityService
     */
    protected $facilityService;

    public function setup()
    {
        $this->facilityService = new ComputeFacilityService();
    }

    /**
     * @test
     */
    public function testMaxFlamme()
    {
        $array = array(5,3,1500);

        foreach($array as &$solde){
            $this->facilityService->submitQuarters($solde);
        }

        $power= new Power(0,1000,0,10000,0,100,0,100);
//        $nuc->setTauxDisponibiliteNuclear(0.10);
//        echo $nuc->getTauxDisponibiliteNuclear()."\n";

        /**
         * @var $newParc ParcFinal
         */
        $newParc= $this->facilities->getSimulatedParc(null,$power);
        $PuisFlamme=$newParc->getPuisFlamme();

        assertEquals($PuisFlamme,1500);

    }

    /**
     * @test
     */
    public function testMachin()
    {
        $day = new \Monmiel\MonmielApiModelBundle\Model\Day();
        $repartionService = $this->getRepartionMock();
        $repartionService->expects($this->once())
                         ->will($this->returnValue($day));
        echo "toto";
    }

    public function getRepartionMock()
    {
        $mockedRepartionService = $this->getMockBuilder("Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1")
                                       ->disableOriginalConstructor()
                                       ->getMock();
        return $mockedRepartionService;
    }
}
