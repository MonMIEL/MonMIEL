<?php

namespace Monmiel\MonmielApiBundle\Tests\Services\TransformersService;
use Monmiel\MonmielApiBundle\Tests\BaseTestCase;
use Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1;
use Monmiel\MonmielApiBundle\Dao\RiakDao;
use Monmiel\MonmielApiModelBundle\Model\Day;
use Monmiel\MonmielApiModelBundle\Model\Quarter;
use Monmiel\MonmielApiModelBundle\Model\Mesure;
use Monmiel\Utils\ConstantUtils;
class TransformersServicesV1Test extends BaseTestCase
{
    /**
     * @var $transformersService TransformersV1
     */
    protected $transformersService;

    public function setup()
    {
       $this->transformersService = new TransformersV1();
       $this->transformersService->setRiakDao($this->getMockedDao());
    }

    /**
     *@test
     */
   public function transformeTotalCalculTest()
    {
        $totalActQuart = 4850;
        $consoAct = 700000000;
        $consoUser = 800000000;

        $expectedResult = ($totalActQuart* $consoUser)/$consoAct;
        $result = $this->transformersService->transformeTotalCalcul($totalActQuart, $consoAct, $consoUser);

        assertThat($result, is($expectedResult));
    }

    /**
     * @test
     */
   public function getTest()
    {
        $expectedDay = $this->getDayObject()->getQuarters()[0]->getConsoTotal();

       /*$this->transformersService->setConsoTotalActuel(new Mesure(500,ConstantUtils::TERAWATT));
        $this->transformersService->setConsoTotalDefinedByUser(new Mesure(600,ConstantUtils::TERAWATT));

        $result = $this->transformersService->get(1)->getQuarters()[0]->getConsoTotal();
        $expectedDay = 6000*600/500;
        var_dump($result);
        assertThat($result, is($expectedDay));*/
    }

    /**
     * @test
     */
    public function updateConsoTotalQuartersForDayByConsoTotalActualAndConsoDefineByUserTest()
    {
        $totalConsoActual = new Mesure(500,ConstantUtils::TERAWATT);//conso 2011
        $totalConsoDefineByUser = new Mesure(600,ConstantUtils::TERAWATT);//conso 2050
        $daytToUpdate = $this->getDayObject();//one day at 2011

        //total quarter updated at 2050
        $dayUpdated=  $this->transformersService->updateConsoTotalQuartersForDayByConsoTotalActualAndConsoDefineByUser($daytToUpdate,$totalConsoActual,$totalConsoDefineByUser);

        $result = $dayUpdated->getQuarters()[0]->getConsoTotal();
        $expectedDay = 6000*600/500;
        assertThat($result, is($expectedDay));

        $result = $dayUpdated->getQuarters()[1]->getConsoTotal();
        $expectedDay = 7000*600/500;
        assertThat($result, is($expectedDay));
    }

    /**
     * @test
     */
    public function updateConsoQuartersByDayIdAndConsoTotalActuelAndConsoDefineByUserTest()
    {
        $totalConsoActual = new Mesure(500,ConstantUtils::TERAWATT);//conso 2011
        $totalConsoDefineByUser = new Mesure(600,ConstantUtils::TERAWATT);//conso 2050

        //total quarter updated at 2050
       /* $dayUpdated=  $this->transformersService->updateConsoQuartersByDayIdAndConsoTotalActuelAndConsoDefineByUser(1,$totalConsoActual,$totalConsoDefineByUser);

        $result = $dayUpdated->getQuarters()[0]->getConsoTotal();
        $expectedDay = 6000*600/500;
        assertThat($result, is($expectedDay));

        $result = $dayUpdated->getQuarters()[1]->getConsoTotal();
        $expectedDay = 7000*600/500;
        assertThat($result, is($expectedDay));*/
    }

    /*
     * @test
     */
    public function calculateMedianOfConsummationForYearTargetTest()
    {
        $this->transformersService->setConsoTotalActuel(new Mesure(500,ConstantUtils::TERAWATT));
        $this->transformersService->setConsoTotalDefinedByUser(new Mesure(600,ConstantUtils::TERAWATT));

        $expectedResult = 555*600/500;
        $result = $this->transformersService->calculateMedianOfConsummationForYearTarget(5855);
        var_dump($result);
        assertThat($result, is($expectedResult));
    }

    public function getMockedDao()
    {
        $day = $this->getDayObject();
        $dao = $this->getMockBuilder("Monmiel\MonmielApiBundle\Dao\RiakDao")
                    ->disableOriginalConstructor()
                    ->getMock();
        $dao->expects($this->any())
            ->method("getDayConso")
            ->will($this->returnValue($day));
        return $dao;
    }

    public function getDayObject()
    {
        $date1 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 00:00:00");
        $date2 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 00:15:00");
        $object = new Day($date1);

        $q1 = new Quarter($date1, 6000, 5050, 5050, 5050, 5050, 0, 5050, 5050);
        $q2 = new Quarter($date2, 7000, 5050, 5050, 5050, 5050, 0, 5050, 5050);

        $object->addQuarters($q1);
        $object->addQuarters($q2);

        return $object;
    }

}
