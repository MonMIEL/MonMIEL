<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1;
use Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1;
use Monmiel\MonmielApiModelBundle\Model\Mesure;
use Monmiel\MonmielApiModelBundle\Model\UnitOfMesure;
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
        /** @var $transformers TransformersV1 */
        $transformers = $this->getContainer()->get("monmiel.transformers.service");
        /** @var $dao \Monmiel\MonmielApiBundle\Dao\RiakDao */
        $dao = $this->getContainer()->get("monmiel.dao.riak");
        /** @var $parcService \Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService */
        $parcService = $this->getContainer()->get("monmiel.facility.service");
        $currentDay = $dao->getDayConso(1);

        $actualMesure = new Mesure(600);
        $actualMesure->setUnitOfMesure(UnitOfMesure::createUnityTerraWatt());
        $targetMesure = new Mesure(650);
        $targetMesure->setUnitOfMesure(UnitOfMesure::createUnityTerraWatt());
        $transformers->setConsoTotalActuel($actualMesure);
        $transformers->getConsoTotalDefinedByUser($targetMesure);
        $day = $transformers->get(1);

        var_dump($currentDay->getQuarter(1));
        var_dump($day->getQuarter(1)); exit;

        $days = array();
        for ($i = 1; $i <= 0; $i++) {
            $days[] = $transformers->get($i);
        }
       // $parc = $parcService->getSimulatedParc();
       // var_dump($parc);
        echo "End of transformer test!";
    }
}
