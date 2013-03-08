<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1;
use \Monmiel\MonmielApiModelBundle\Model\Day;
use \Monmiel\MonmielApiModelBundle\Model\Quarter;
use \Monmiel\MonmielApiModelBundle\Model\Power;

/**
 * Created by JetBrains PhpStorm.
 * User: Dadoo
 * Date: 08/03/13
 * Time: 09:26
 * To change this template use File | Settings | File Templates.
 */
class TestProductionCapacityCommand extends ContainerAwareCommand

{
    protected function configure()
    {
        $this
            ->setName("monmiel:test:testCapacity")
            ->setDescription("Compute the production capacity for each energy and for target year");
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        echo ("==================== Debut ====================");

        $quarter = new quarter("21/03/2012",100,5,5,10,60,20,0,0,0,0,0,0);

        $repartitionService = new \Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1();
        $quarterupdated = $repartitionService->updateQuarterForProductionCapacity($quarter);
        echo("Capacite de production de l'eolien :".$quarterupdated->getEolien()."\n");
        echo("Capacite de production du photovoltaique :".$quarterupdated->getPhotovoltaique()."\n");
        echo("Capacite de production du nucleaire :".$quarterupdated->getNucleaire()."\n");
        echo("Capacite de production de l'hydraulique :".$quarterupdated->getHydraulique()."\n");

        echo ("==================== Fin ====================");
    }
}
