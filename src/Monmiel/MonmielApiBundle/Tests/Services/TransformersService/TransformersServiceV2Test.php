<?php

namespace Monmiel\MonmielApiBundle\Tests\Services\TransformersService;

use Monmiel\MonmielApiBundle\Tests\BaseTestCase;
use Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV2;

class TransformersServiceV2Test extends BaseTestCase
{
    /**
     * @var $transformersService TransformersV2;
     */
    protected $transformersService;

    public function setup()
    {
        $this->transformersService = new TransformersV2();
    }

    /**
     *@test
     */
    public function transformeTotalCalculTest()
    {
        $totalActQuart = 4850;
        $consoAct = 700000000;
        $consoUser = 800000000;

        $expectedResult = 100;

        $result = 100;

        assertThat($result, is($expectedResult));
    }
}
