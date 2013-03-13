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
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Eolien;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }



    /**
     *
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Eolien::setPowerEolien
     * @todo   Implement testSetPowerEolien().
     */
    public function testSetPowerEolien()
    {

        $this->object->setPowerEolien(4);
        $result= 4 / $this->object->getFacteurChargeEolien();
        assertThat($this->object->getPowerEolien(),is($result));
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Eolien::getPowerEolien
     * @todo   Implement testGetPowerEolien().
     */
    public function testGetPowerEolien()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Eolien::setFacteurChargeEolien
     * @todo   Implement testSetFacteurChargeEolien().
     */
    public function testSetFacteurChargeEolien()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Eolien::getFacteurChargeEolien
     * @todo   Implement testGetFacteurChargeEolien().
     */
    public function testGetFacteurChargeEolien()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Eolien::setTauxDisponibiliteEolien
     * @todo   Implement testSetTauxDisponibiliteEolien().
     */
    public function testSetTauxDisponibiliteEolien()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Eolien::getTauxDisponibiliteEolien
     * @todo   Implement testGetTauxDisponibiliteEolien().
     */
    public function testGetTauxDisponibiliteEolien()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Monmiel\MonmielApiModelBundle\Model\Parc\Eolien::getParcEolien
     * @todo   Implement testGetParcEolien().
     */
    public function testGetParcEolien()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
    }
}
