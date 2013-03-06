<?php

namespace Monmiel\MonmielApiBundle\Tests\Services\FacilityService;

use Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService;
use Monmiel\MonmielApiBundle\Tests\BaseTestCase;

class ComputeFacilityServiceTest extends BaseTestCase
{

    protected $facilityService;

    public function setup()
    {
        $this->facilityService = new ComputeFacilityService();
    }

    /**
     * @test
     */
    public function testMax()
    {
        echo "salut";
    }
}
