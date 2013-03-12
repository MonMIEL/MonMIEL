<?php

namespace Monmiel\MonmielApiModelBundle\Test\Model;
use Monmiel\MonmielApiModelBundle\Model\Mesure;
use \Monmiel\MonmielApiBundle\Tests\BaseTestCase;
use \Monmiel\Utils\ConstantUtils;
/**
 * User: patrice
 * Date: 06/03/13
 * Time: 16:41
 * unit test for the class mesure
 */
class MesureTest extends BaseTestCase
{
    function setUp(){

    }

    /**
     *@test
     */
    function testConvertMesureTerraWattToMesureGigaWatt()
    {
        $mesureTerrawatt = new Mesure(5,\Monmiel\Utils\ConstantUtils::TERAWATT);
        $expectResult = 5000;
        $result = Mesure::convertMesureByOtherUnitOfMesure($mesureTerrawatt,ConstantUtils::GIGAWATT);
        assertThat($result->getValue(), is($expectResult));
    }

    /**
     *@test
     */
    function testConvertMesureGigaWattToMesureTerrWatt(){
        $mesureGigawatt = new Mesure(4000, \Monmiel\Utils\ConstantUtils::GIGAWATT);
        $expectResult = 4;
        $result = Mesure::convertMesureByOtherUnitOfMesure($mesureGigawatt,ConstantUtils::TERAWATT);
        assertThat($result->getValue(), is($expectResult));
    }

    /**
     *@test
     */
    function testIsCompatible(){
        /**
         * @var $mesureGigawatt1 Mesure
         */
        $mesureGigawatt1 = new Mesure(4000, ConstantUtils::TERAWATT);
        /**
         * @var $mesureGigawatt2 Mesure
         */
        $mesureGigawatt2 = new Mesure(4000, ConstantUtils::GIGAWATT);
        $expectResult = false;
        /**
         * @var $result bool
         */
        $result = Mesure::isCompatible($mesureGigawatt1,$mesureGigawatt2);
        assertThat($result, is($expectResult));
    }
    /**
     *@test
     */
    function testIsEquals(){
        /**
         * @var $mesureGigawatt1 Mesure
         */
        $mesureGigawatt1 = new Mesure(4000, ConstantUtils::GIGAWATT);
        /**
         * @var $mesureGigawatt2 Mesure
         */
        $mesureGigawatt2 = new Mesure(4000, ConstantUtils::GIGAWATT);
        $expectResult = true;
        /**
         * @var $result bool
         */
        $result = Mesure::isEqualsMesure($mesureGigawatt1,$mesureGigawatt2);
        assertThat($result, is($expectResult));
    }

    /**
     *@test
     */
    function testIsTerrawatt()
    {
        $mesureTerrawatt = new Mesure(5,ConstantUtils::TERAWATT);
        $result = $mesureTerrawatt->isTerraWatt();
        $expectResult = true;
        var_dump($mesureTerrawatt);
        assertThat($result, is($expectResult));
    }

    /**
     *@test
     */
    function testIsTerrawattHeure()
    {
        $mesureTerrawatt = new Mesure(5,ConstantUtils::TERAWATT_HOUR);
        $result = $mesureTerrawatt->isTerraWattHeure();
        $expectResult = true;
        var_dump($mesureTerrawatt);
        assertThat($result, is($expectResult));
    }

    /**
     *@test
     */
    function testIsGigawatt()
    {
        $mesureTerrawatt = new Mesure(5,ConstantUtils::GIGAWATT);
        $result = $mesureTerrawatt->isGigaWatt();
        $expectResult = true;
        var_dump($mesureTerrawatt);
        assertThat($result, is($expectResult));
    }

    /**
     *@test
     */
    function testIsGigawattHeure()
    {
        $mesureTerrawatt = new Mesure(5,ConstantUtils::GIGAWATT_HOUR);
        $result = $mesureTerrawatt->isGigaWattHour();
        $expectResult = true;
        var_dump($mesureTerrawatt);
        assertThat($result, is($expectResult));
    }
    /**
     * @test
     */
    function testIsMegaWatt()
    {
        $mesureTerrawatt = new Mesure(5,ConstantUtils::MEGAWATT);
        $result = $mesureTerrawatt->isMegaWatt();
        $expectResult = true;
        var_dump($mesureTerrawatt);
        assertThat($result, is($expectResult));
    }

}
