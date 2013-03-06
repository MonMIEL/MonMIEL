<?php

namespace Monmiel\MonmielApiBundle\Tests;

require_once("Hamcrest/Hamcrest.php");

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseTestCase extends WebTestCase {

    protected function setup() {
        self::$kernel = self::createKernel();
        self::$kernel->boot();
    }

    protected function getService($serviceId) {
        return static::$kernel->getContainer()->get($serviceId);
    }

    public function testDummy() {
        assertThat(true, is(true));
    }
}
