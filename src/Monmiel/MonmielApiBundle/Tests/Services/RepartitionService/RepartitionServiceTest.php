<?php
namespace Monmiel\MonmielApiBundle\Tests\Services\FacilityService;

use Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1;
use Monmiel\MonmielApiBundle\Tests\BaseTestCase;
use Monmiel\MonmielApiModelBundle\Model\Day;
use Monmiel\MonmielApiModelBundle\Model\Quarter;
use Monmiel\MonmielApiModelBundle\Model\Power;
/**
 * Created by JetBrains PhpStorm.
 * User: Dadoo
 * Date: 12/03/13
 * Time: 09:28
 * To change this template use File | Settings | File Templates.
 */
class RepartitionServiceTest extends BaseTestCase
{
    /**
     * @var $repartitionService RepartitionServiceV1
     */
    protected $repartitionService;

    public function setup()
    {
        $this->repartitionService = new RepartitionServiceV1();
    }

    /**
     * @test
     */
    public function testComputeMaxProductionPerEnergy(){
        /**
         * @var $day Day
         */
        $day = $this->getDayObject();

       /**
        * @var $quarter Quarter
        */
        $quarter = $day->getQuarter(1);
        $this->repartitionService->setReferenceParcPower(new Power(1,1,1,1,1,1,1,1));
        $this->repartitionService->setTargetParcPower(new Power(1,1,1,1,1,1,1,1));

        /**
         * @var $quarterActual Quarter
         */
        $resultat = $this->repartitionService->computeMaxProductionPerEnergy($quarter);
        assertThat($quarter->getDate(), is($resultat->getDate()));
    }

    /**
     * @return Day
     */
    public function getDayObject()
    {
        $date1 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 00:00:00");
        $date2 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 00:15:00");
        $object = new Day($date1);

        $q1 = new Quarter($date1, 1026, 500, 100, 0, 20, 344, 62, 0);
        $q2 = new Quarter($date2, 1104, 540, 33, 0, 100, 376, 55, 0);

        $object->addQuarters($q1);
        $object->addQuarters($q2);

        return $object;
    }
}
