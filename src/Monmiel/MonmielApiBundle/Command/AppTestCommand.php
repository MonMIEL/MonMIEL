<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1;
class AppTestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("monmiel:test:transformer")
            ->setDescription("Extract Data from RTE and populate Riak");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $repartitionService RepartitionServiceV1 */
        $repartitionService = $this->getContainer()->get("monmiel.repartition.service");
        /** @var $dao \Monmiel\MonmielApiBundle\Dao\RiakDao */
        $dao = $this->getContainer()->get("monmiel.dao.riak");
        /** @var $parcService \Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService */
        $parcService = $this->getContainer()->get("monmiel.facility.service");
        $currentDay = $dao->getDayConso(1);
        $day = $repartitionService->get(1);

        $days = array();
        for ($i = 1; $i <= 365; $i++) {
            $days[] = $repartitionService->get($i);
        }
        $parc = $parcService->getSimulatedParc();
        var_dump($parc);
        echo " who let's the dog out whoa !";
    }
}
