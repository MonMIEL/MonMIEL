<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Monmiel\MonmielApiModelBundle\Model\Mesure;

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
        /** @var $dao  \Monmiel\MonmielApiBundle\Dao\RiakDao */
        $dao = $this->getContainer()->get("monmiel.dao.riak");
        /** @var $transformers \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1 */
        $transformers = $this->getContainer()->get("monmiel.transformers.v1.service");
        $userMesure = new Mesure(650);
        $userMesure->setUnitOfMesure(\Monmiel\MonmielApiModelBundle\Model\UnitOfMesure::createUnityTerraWatt());
        $transformers->setConsoTotalDefinedByUser($userMesure);
        $userMesure2 = new Mesure(600);
        $userMesure2->setUnitOfMesure(\Monmiel\MonmielApiModelBundle\Model\UnitOfMesure::createUnityTerraWatt());
        $transformers->setConsoTotalActuel($userMesure2);
        $currentDay = $transformers->get(1);
        var_dump($dao->getDayConso(1)->getQuarter(1));
        var_dump($currentDay->getQuarter(1));exit;

        $days = array();
        for ($i = 1; $i <= 365; $i++) {
            $days[] = $repartitionService->get($i);
        }
        $parc = $parcService->getSimulatedParc();
        var_dump($parc);
        echo " who let's the dog out whoa !";
    }
}
