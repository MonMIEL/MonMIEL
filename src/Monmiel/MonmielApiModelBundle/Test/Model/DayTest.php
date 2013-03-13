<?php
namespace Monmiel\MonmielApiModelBundle\Model;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-13 at 08:54:59.
 */
class DayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Day
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $q1=new Quarter("2013-01-02",5000,0,0,0,5000,0,0,0,0,0,0,0,0);
        $q2=new Quarter("2013-01-02",20000,0,0,0,20000,0,0,0,0,0,0,0,0);
        $tmp = array();
        array_push($tmp,$q1);
        array_push($tmp,$q2);

        $this->object = new Day(date_create_from_format('Y-m-d','2013-01-02'),$tmp);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Day::getKey
     * @todo   Implement testGetKey().
     */
    public function testGetKey()
    {
        $this->object->setDateTime(date_create_from_format('Y-m-d','2013-05-08'));
        //echo $this->object->getKey();
        $this->assertEquals("2013-05-08",$this->object->getKey());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Day::getMax
     * @todo   Implement testGetMax().
     */
    public function testGetMax()
    {
        $q1 = new Quarter("2013-08-09",7530,589,336,994,5588,23,0,0);
        $q2 = new Quarter("2013-08-09",14970,5859,8336,94,258,423,0,0);
        $tmp = array();
        array_push($tmp,$q1);
        array_push($tmp,$q2);
        $this->object->setQuarters($tmp);
        $tmpResult = $this->object->getMax();
        $this->assertEquals(994,$tmpResult["hydraulique"]);
        $this->assertEquals(5588,$tmpResult["nucleaire"]);
        $this->assertEquals(423,$tmpResult["photovoltaique"]);
        $this->assertEquals(5859,$tmpResult["eolien"]);
        $this->assertEquals(8336,$tmpResult["flamme"]);
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Day::addQuarters
     * @todo   Implement testAddQuarters().
     */
    public function testAddQuarters()
    {
        $qTmp=new Quarter("2013-05-02",15000,0,0,0,15000,0,0,0,0,0,0,0,0);
        $this->object->addQuarters($qTmp);
        $tmpResult =array();
        $tmpResult = $this->object->getQuarters();
        $this->assertEquals($tmpResult[sizeof($tmpResult)-1],$qTmp);
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Day::getQuarter
     * @todo   Implement testGetQuarter().
     */
    public function testGetQuarter()
    {
        $q1=new Quarter("2013-05-02",5000,0,0,0,5000,0,0,0,0,0,0,0,0);
        $q2=new Quarter("2013-05-02",20000,0,0,0,20000,0,0,0,0,0,0,0,0);

        $tmp = array();

        array_push($tmp,$q1);
        array_push($tmp,$q2);
        $this->object->setQuarters($tmp);
        $this->assertEquals($q1,$this->object->getQuarter(0));
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Day::setDateTime
     * @todo   Implement testSetDateTime().
     */
    public function testSetDateTime()
    {
        $this->object->setDateTime(date_create_from_format('Y-M-D','2013-02-03'));
        $this->assertEquals(date_create_from_format('Y-M-D','2013-02-03'),$this->object->getDateTime());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Day::getDateTime
     * @todo   Implement testGetDateTime().
     */
    public function testGetDateTime()
    {
       $this->assertNotNull($this->object->getDateTime());
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Day::setQuarters
     * @todo   Implement testSetQuarters().
     */
    public function testSetQuarters()
    {
        $q1=new Quarter("2013-05-02",5000,0,0,0,5000,0,0,0,0,0,0,0,0);
        $q2=new Quarter("2013-05-02",20000,0,0,0,20000,0,0,0,0,0,0,0,0);

        $tmp = array();

        array_push($tmp,$q1);
        array_push($tmp,$q2);
        $this->object->setQuarters($tmp);
        $this->assertEquals($tmp,$this->object->getQuarters());

    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Day::getQuarters
     * @todo   Implement testGetQuarters().
     */
    public function testGetQuarters()
    {
        $this->assertNotNull($this->object->getQuarters());
    }
}
