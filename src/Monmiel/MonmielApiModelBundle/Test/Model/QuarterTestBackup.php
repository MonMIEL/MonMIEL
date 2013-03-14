<?php

namespace Monmiel\MonmielApiModelBundle\Test\Model;

use Kbrw\RiakBundle\Tests\Model\ModelTestCase;

class QuarterTest extends ModelTestCase
{

    protected $serializarionMethod          = "json";
    protected $systemUnderTestFullClassName = "Monmiel\MonmielApiModelBundle\Model\Quarter";
    protected $testedModels                 = array("regular");

    protected function getTestFileBasePath()
    {
        return dirname(__FILE__) . "/../../Resources/test/model/quarter";
    }
}
