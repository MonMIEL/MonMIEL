<?php
namespace Monmiel\MonmielApiModelBundle\Model\Parc;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-12 at 15:24:56.
 */
class NuclearTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Nuclear
     */
    protected $nuclear;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->nuclear = new Nuclear;
    }
    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }
    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Nuclear::setPowerNuclear
     */
    public function testSetPowerNuclear()
    {
        $PowerNuclear = 500;
        $percentOfMix = 0.50;
        $this->nuclear->setPowerNuclear($PowerNuclear,$percentOfMix);
        $this->assertNotNull($this->nuclear->getFacteurChargeNuclear(), "this value mast not null becase it is initialize at setPowerNuclear method ");

        //cas 1, pourcentage mix >= 0.75
        $percentOfMix = 0.88;
        $exeptedValue = 0.76;//max
        $this->nuclear->setPowerNuclear($PowerNuclear,$percentOfMix);
        $result = $this->nuclear->getFacteurChargeNuclear();
        assertThat($result, is($exeptedValue));

        //cas 2: 0.25<pourcentage mix < 0.75
        $percentOfMix = 0.50;
        $exeptedValue = 0.855;//(0.75 - 0.50)*0.38 + 0.75
        $this->nuclear->setPowerNuclear($PowerNuclear,$percentOfMix);
        $result = $this->nuclear->getFacteurChargeNuclear();
        assertThat($result, is($exeptedValue));

        //cas 3: pourcentage mix <= 0.25
        $percentOfMix = 0.25;
        $exeptedValue = 0.95;//max
        $this->nuclear->setPowerNuclear($PowerNuclear,$percentOfMix);
        $result = $this->nuclear->getFacteurChargeNuclear();
        assertThat($result, is($exeptedValue));
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Nuclear::getPowerNuclear
     */
    public function testGetPowerNuclear()
    {
        $PowerNuclear = 500;
        $percentOfMix = 0.50;
        $this->nuclear->setPowerNuclear($PowerNuclear,$percentOfMix);
        $this->assertEquals(0.855,   $this->nuclear->getFacteurChargeNuclear());
        $exeptedValue = 500*1000/855;
        $result = $this->nuclear->getPowerNuclear();
        assertThat($result, is($exeptedValue));

    }

    public function testConstructeur(){
        $this->nuclear = new Nuclear();
        //they must take the default values
        $this->assertNotNull($this->nuclear->getFacteurChargeNuclear(),"this value must a default");
        $this->assertNotNull($this->nuclear->getParcNuclear(),"this value must a default");
        $this->assertNotNull($this->nuclear->getPowerNuclear(),"this value must a default");
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Nuclear::getParcNuclear
     */
    public function testGetParcNuclear()
    {
        $PowerNuclear = 500;
        $percentOfMix = 0.50;
        $exeptedValue = 0.855;//(0.75 - 0.50)*0.38 + 0.75
        //facteur de charge
        $this->nuclear->setPowerNuclear($PowerNuclear,$percentOfMix);
        $result = $this->nuclear->getFacteurChargeNuclear();
        assertThat($result, is($exeptedValue));
        //à faire après confirmation Talbot

    }


}
