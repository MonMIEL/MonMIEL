<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 14/03/13
 * Time: 15:29
 * To change this template use File | Settings | File Templates.
 */
namespace Monmiel\MonmielApiBundle\Services\ParcService;

use Monmiel\MonmielApiBundle\Tests\BaseTestCase;
use Monmiel\MonmielApiBundle\Services\ParcService\ParcServiceInterface;
use Monmiel\MonmielApiModelBundle\Model\Year;
use Monmiel\MonmielApiModelBundle\Model\Parc\GlobalParc;
use Monmiel\MonmielApiModelBundle\Model\Power;

class ParcServiceTest extends BaseTestCase
{
    /**
     * @var ParcService
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new ParcService();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }


    /**
     * @covers $flamePower float
     */
    public function submitFlamePowerTest()
    {
      $this->object->submitFlamePower(5869.236);
      $this->assertEquals($this->object->getFinalParcPower()->getFlamme()->getPower(),5869.236);


    }

    /**
     * @covers \Monmiel\MonmielApiModelBundle\Model\Year $year
     * @covers float $hourInterval
     */
    public function getPowerTest()
    {
        $y = new Year("2013",7856.32,896.45,8966.32,6685.32,5896.522,4786.23);
        $interval = 563.23;
        $p = new Power($y->getConsoTotalFlamme()/$interval,$y->getConsoTotalHydraulique()/$interval,0,$y->getConsoTotalNucleaire()/$interval,0,$y->getConsoTotalPhotovoltaique()/$interval,0,$y->getConsoTotalEolien()/$interval);
        $this->assertEquals($this->object->getPower($y,$interval),$p);
    }

    public function getSimulatedParcTest($year)
    {

    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getFinalPowerTest()
    {

    }

    /**
     * @param $year Year
     * @param $interval float
     */
    public function setRefParcPowerTest($year, $interval = 8760)
    {

    }

    /**
     * @param $year Year
     * @param $interval float
     */
    public function setTargetParcPowerTest($year, $interval = 8760)
    {

    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Parc\GlobalParc
     */
    public function getRefParcPowerTest()
    {

    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Parc\GlobalParc
     */
    public function getTargetParcPowerTest()
    {

    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Parc\GlobalParc
     */
    public function getFinalParcPowerTest()
    {
        return $this->finalParcPower;
    }

}
