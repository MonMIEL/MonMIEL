<?php
namespace Monmiel\MonmielApiModelBundle\Model;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-12 at 15:35:14.
 */
class PowerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Power
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Power(500,20,300,600,700,120,23,55);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::toArray
     * @todo   Implement testToArray().
     */
    public function testToArray()
    {
        $this->assertEmpty(array_diff_assoc(Array(
            "nucleaire" => $this->object->getNuclear(),
            "photovoltaique" => $this->object->getPhotovoltaic(),
            "eolien" => $this->object->getWind(),
            "hydraulique" => $this->object->getHydraulic(),
            "flammes" => $this->object->getFlame(),
            "step" => $this->object->getStep(),
            "import" => $this->object->getImport()),$this->object->toArray()));
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::getTotal
     * @todo   Implement testGetTotal().
     */
    public function testGetTotal()
    {
        $this->assertEquals($this->object->getTotal(),2318);
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::setFlame
     * @todo   Implement testSetFlame().
     */
    public function testSetFlame()
    {
       $this->object->setFlame(100.56);
       $this->assertEquals(100.56,$this->object->getFlame());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::getFlame
     * @todo   Implement testGetFlame().
     */
    public function testGetFlame()
    {
        $this->assertNotNull($this->object->getFlame());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::setHydraulic
     * @todo   Implement testSetHydraulic().
     */
    public function testSetHydraulic()
    {
        $this->object->setHydraulic(200.88);
        $this->assertEquals(200.88,$this->object->getHydraulic());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::getHydraulic
     * @todo   Implement testGetHydraulic().
     */
    public function testGetHydraulic()
    {
        $this->assertNotNull($this->object->getHydraulic());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::setImport
     * @todo   Implement testSetImport().
     */
    public function testSetImport()
    {
        $this->object->setImport(546498465.23);
        $this->assertEquals(546498465.23,$this->object->getImport());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::getImport
     * @todo   Implement testGetImport().
     */
    public function testGetImport()
    {
        $this->assertNotNull($this->object->getImport());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::setNuclear
     * @todo   Implement testSetNuclear().
     */
    public function testSetNuclear()
    {
        $this->object->setNuclear(5431313.23);
        $this->assertEquals(5431313.23,$this->object->getNuclear());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::getNuclear
     * @todo   Implement testGetNuclear().
     */
    public function testGetNuclear()
    {
        $this->assertNotNull($this->object->getNuclear());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::setOther
     * @todo   Implement testSetOther().
     */
    public function testSetOther()
    {
        $this->object->setOther(4665486.89);
        $this->assertEquals(4665486.89,$this->object->getOther());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::getOther
     * @todo   Implement testGetOther().
     */
    public function testGetOther()
    {
        $this->assertNotNull($this->object->getOther());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::setPhotovoltaic
     * @todo   Implement testSetPhotovoltaic().
     */
    public function testSetPhotovoltaic()
    {
        $this->object->setPhotovoltaic(46.89);
        $this->assertEquals(46.89,$this->object->getPhotovoltaic());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::getPhotovoltaic
     * @todo   Implement testGetPhotovoltaic().
     */
    public function testGetPhotovoltaic()
    {
        $this->assertNotNull($this->object->getPhotovoltaic());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::setStep
     * @todo   Implement testSetStep().
     */
    public function testSetStep()
    {
        $this->object->setStep(49849.8);
        $this->assertEquals(49849.8,$this->object->getStep());
    }
    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::getStep
     * @todo   Implement testGetStep().
     */
    public function testGetStep()
    {
        $this->assertNotNull($this->object->getStep());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::setWind
     * @todo   Implement testSetWind().
     */
    public function testSetWind()
    {
        $this->object->setWind(56.238);
        $this->assertEquals(56.238,$this->object->getWind());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Power::getWind
     * @todo   Implement testGetWind().
     */
    public function testGetWind()
    {
        $this->assertNotNull($this->object->getWind());
    }
}
