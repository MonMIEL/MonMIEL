<?php

namespace Monmiel\MonmielApiBundle\Tests\Services\TransformersService;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1;

class TransformersServicesV1Test extends WebTestCase
{

    /**
     * @var \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1 $transformersService
     */
    protected $transformersService;

    public function setup()
    {
        $this->transformersService = new TransformersV1();
    }

    /**
     * @test
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


}
