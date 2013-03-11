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


    /*function testConvertMesureTerraWattToMesureGigaWatt()
    {
        $mesureTerrawatt = new Mesure(5,\Monmiel\Utils\ConstantUtils::TERAWATT);

        $expectResult = 5000;

        $result = Mesure::convertMesureByOtherUnitOfMesure($mesureTerrawatt,ConstantUtils::GIGAWATT);

        assertThat($result->getValue(), is($expectResult));
    }*/

    /**
     * @test
     */
    function testIsTerrawatt()
    {
        $mesureTerrawatt = new Mesure(5,\Monmiel\Utils\ConstantUtils::TERAWATT);
        $result = $mesureTerrawatt->isTerraWatt();
        $expectResult = true;
        var_dump($mesureTerrawatt);
        assertThat($result, is($expectResult));
    }
    /**
     *
     */
    /*function testConvertMesureGigaWattToMesureTerrWatt(){

        $mesureGigawatt = new Mesure(4000, \Monmiel\Utils\ConstantUtils::GIGAWATT);
        $expectResult = 4;

        $result = Mesure::convertMesureByOtherUnitOfMesure($mesureGigawatt,ConstantUtils::TERAWATT);

        assertThat($result->getValue(), is($expectResult));
    }*/
}
