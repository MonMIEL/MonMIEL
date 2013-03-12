<?php
namespace Monmiel\MonmielApiBundle\Tests\Services\FacilityService;

use Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1;
use Monmiel\MonmielApiBundle\Tests\BaseTestCase;
/**
 * Created by JetBrains PhpStorm.
 * User: Dadoo
 * Date: 12/03/13
 * Time: 09:28
 * To change this template use File | Settings | File Templates.
 */
class RepartitionServiceTest extends BaseTestCase
{
    /**
     * @var $repartitionService RepartitionServiceV1
     */
    protected $repartitionService;

    public function setup()
    {
        $this->repartitionService = new RepartitionServiceV1();
    }

    public function testRepartition(){
        echo "---------- Debut ----------\n";
        for($i=0;$i<1;$i++){
            echo "---------- Jour".($i + 1)." ----------\n";
            $day = $this->repartitionService->get($i);
            for($j=0;$j<96;$j++){
                /**
                 * @var $quarter \Monmiel\MonmielApiModelBundle\Model\Quarter
                 */
                $quarter = $day->getQuarter($j);
                echo "----- Quart heure ".$j." : \n";
                echo "Nucleaire = ".$quarter->getNucleaire();
                echo "Eolien = ".$quarter->getEolien();
                echo "Photovoltaique = ".$quarter->getPhotovoltaique();
                echo "Hydraulique = ".$quarter->getHydraulique();
                echo "Flamme = ".$quarter->getFlamme();
            }
        }
        echo "---------- Fin ----------\n";
    }
}
