<?php
namespace Monmiel\MonmielApiModelBundle\Model\Parc;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-12 at 15:24:14.
 */
class EolienTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Eolien
     */
    protected $eolien;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->eolien = new Eolien;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @test
     */
    public function testAvalaibilityRate(){
        $this->eolien = new Eolien(0,60,0,75,5000,1);
        $this->eolien->setAvailabilityRate(0.60);
        $exceptedValue = 0.6;
        $result = $this->eolien->getAvailabilityRate();
        assertThat($result,is($exceptedValue));
    }

    /**
     * @test
     */
    public function testLoadFactor(){
        $this->eolien = new Eolien(0,60,0,75,5000,1);
        $this->eolien->setLoadFactor(0.75);
        $exceptedValue = 0.75;
        $result = $this->eolien->getLoadFactor();
        assertThat($result,is($exceptedValue));
    }

    /**
     * @test
     */
    public function testPowerUnit(){
        $this->eolien = new Eolien(0,60,0,75,5000,1);
        $this->eolien->setLoadFactor(0.75);
        $this->eolien->setAvailabilityRate(0.60);
        $exceptedValue = 1.5;
        $result = $this->eolien->getPowerUnit();
        assertThat($result,is($exceptedValue));
    }

    /**
     * @test
     */
    public function testPower(){
        $this->eolien = new Eolien(0,60,0,75,5000,1);
        $this->eolien->setLoadFactor(0.75);
        $this->eolien->setAvailabilityRate(0.60);
        $this->eolien->setPower(5000);
        $exceptedValue = 4000;
        $result = intval($this->eolien->getPower());
        assertThat($result,is($exceptedValue));
    }


    /**
     *
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Eolien::setPowerEolien
     */
    /*public function testSetPowerEolien()
    {

        $this->eolien =
        $this->eolien->setFacteurChargeEolien(75/100);
        $this->eolien->setPowerEolien(500);

        $expectedValue = 500*100/75;
        $result = $this->eolien->getPowerEolien();
        assertThat($result, is($expectedValue));

    }*/

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Eolien::getPowerEolien
     */
    /*public function testGetPowerEolien()
    {
        $this->eolien->setFacteurChargeEolien(25/100);
        $this->eolien->setPowerEolien(400);

        $result = $this->eolien->getPowerEolien();

        $this->assertNotNull($result, "must not null");
    }*/

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Eolien::setFacteurChargeEolien
     */
    /*public function testSetFacteurChargeEolien()
    {
        $this->eolien->setFacteurChargeEolien(75/100);
        $result = $this->eolien->getFacteurChargeEolien();
        $this->assertNotNull($result, "must not null");
    }*/
}
