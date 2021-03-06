<?php
namespace Monmiel\MonmielApiModelBundle\Model\Parc;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-12 at 15:24:39.
 */
class HydraulicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Hydraulic
     */
    protected $hydraulic;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->hydraulic = new Hydraulic;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Hydraulic::setPowerHydraulic
     */
   /* public function testSetPowerHydraulic()
    {
        $this->hydraulic->setFacteurChargeHydraulique(0.75);
        $this->hydraulic->setPowerHydraulic(500);
        $expectedValue = 500*100/75;
        $result = $this->hydraulic->getPowerHydraulic();
        $this->assertNotNull($result);
        assertThat($result, is($expectedValue));
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Hydraulic::setFacteurChargeHydraulique
     */
    /*public function testSetFacteurChargeHydraulique()
    {
        $this->hydraulic->setFacteurChargeHydraulique(0.75);
        $expectedValue = 0.75;
        $result = $this->hydraulic->getFacteurChargeHydraulique();
        $this->assertNotNull($result);
        assertThat($result, is($expectedValue));
    }*/

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Hydraulic::getFacteurChargeHydraulique
     */
    /*public function testGetFacteurChargeHydraulique()
    {
        $this->hydraulic->setFacteurChargeHydraulique(0.75);
        $expectedValue = 0.75;
        $result = $this->hydraulic->getFacteurChargeHydraulique();
        $this->assertNotNull($result);
        assertThat($result, is($expectedValue));
    }*/

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Hydraulic::getParcHydraulic
     */
  /*  public function testGetParcHydraulic()
    {
        $this->hydraulic->setFacteurChargeHydraulique(0.75);
        $this->hydraulic->setPowerHydraulic(500);
        $this->hydraulic->setTauxDisponibiliteHydraulique(0.80);
        $expectedValue = (500*100/75)*(100/80);
        $result = $this->hydraulic->getParcHydraulic();
        $this->assertNotNull($result);
        assertThat($result, is($expectedValue));
    }*/

    /**
     * @test
     */
    public function testAvalaibilityRateHydro(){
        $this->hydraulic = new Hydraulic(0,60,0,75,6000,1);
        $this->hydraulic->setAvailabilityRate(0.60);
        $exceptedValue = 0.60;
        $result = $this->hydraulic->getAvailabilityRate();
        assertThat($result,is($exceptedValue));
    }

    /**
     * @test
     */
    public function testLoadFactorHydro(){
        $this->hydraulic = new Hydraulic(0,60,0,75,5000,1);
        $this->hydraulic->setLoadFactor(0.72);
        $exceptedValue = 0.72;
        $result = $this->hydraulic->getLoadFactor();
        assertThat($result,is($exceptedValue));
    }

    /**
     * @test
     */
    public function testPowerUnitHydro(){
        $this->hydraulic = new Hydraulic(0,70,0,75,5000,1);
        $this->hydraulic->setLoadFactor(0.75);
        $this->hydraulic->setAvailabilityRate(0.60);
        $exceptedValue = 1;
        $result = $this->hydraulic->getPowerUnit();
        assertThat($result,is($exceptedValue));
    }

    /**
     * @test
     */
    public function testPowerHydro(){
        $this->hydraulic = new Hydraulic(0,60,0,75,5000,1);
        $this->hydraulic->setLoadFactor(0.75);
        $this->hydraulic->setAvailabilityRate(0.60);
        $this->hydraulic->setPower(50000);
        $exceptedValue = 40000;
        $result = intval($this->hydraulic->getPower());
        assertThat($result,is($exceptedValue));
    }
}
