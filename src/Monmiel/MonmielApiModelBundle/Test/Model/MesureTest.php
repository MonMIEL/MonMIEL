<?php

namespace Monmiel\MonmielApiModelBundle\Test\Model;

use Monmiel\MonmielApiModelBundle\Model\Mesure;
use \Monmiel\MonmielApiModelBundle\Model\UnitOfMesure;
use \Monmiel\MonmielApiBundle\Tests\BaseTestCase;
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
     * @test
     */
    function testConvertMesureTerraWattToMesureGigaWatt(){
        $mesureTerrawatt = new Mesure(5);
        $mesureTerrawatt->setUnitOfMesure(UnitOfMesure::createUnityTerraWatt());
        /**
         * @var $expectResult float
         */
        $expectResult = 5000;
        /**
         * @var Mesure
         */
        $result = Mesure::convertMesureByOtherUnitOfMesure($mesureTerrawatt,UnitOfMesure::createUnityGigaWatt());
        assertThat($result->getValue(), is($expectResult));
    }

    /**
     * @test
     */
    function testConvertMesureGigaWattToMesureTerrWatt(){

        $mesureGigawatt = new Mesure(4000);
        $mesureGigawatt->setUnitOfMesure(UnitOfMesure::createUnityGigaWatt());
        /**
         * @var $expectResult float
         */
        $expectResult = 4;
        /**
         * @var Mesure
         */
        $result = Mesure::convertMesureByOtherUnitOfMesure($mesureGigawatt,UnitOfMesure::createUnityTerraWatt());
        assertThat($result->getValue(), is($expectResult));
    }
}
