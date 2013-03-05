<?php

namespace Monmiel\MonmielApiBundle\Tests\Services\FacilityService;

use Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ComputeFacilityServiceTest extends WebTestCase
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
