<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV2;
use \Monmiel\MonmielApiModelBundle\Model\Day;
use \Monmiel\MonmielApiModelBundle\Model\Quarter;
use \Monmiel\MonmielApiModelBundle\Model\Year;
class TestTransformersDataYerReferenceCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("monmiel:test:transV2")
            ->setDescription("Extract Data from RTE and populate Riak");
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        $dao = $this->getContainer()->get("monmiel.dao.riak");

        /**
         * @var $consoTotalNucleaire float
         * @var $consoTotalEolien float
         * @var $consoTotalPhotovoltaique float
         * @var $consoTotalFlamme float
         * @var $consoTotalHydraulique float
         */
        $consoTotalNucleaire = 0; $consoTotalEolien = 0;$consoTotalPhotovoltaique = 0; $consoTotalFlamme = 0; $consoTotalHydraulique = 0;

        for($i = 1; $i<365; $i++){
            /**
             * @var $day Day
             */
            $day = $dao->getDayConso($i);
            var_dump($day);

            /**
             * @var $listQuarter array<Quarter>
             */
            $listQuarter = $day->getQuarters();
            var_dump($listQuarter);
            foreach ($listQuarter as $quarter) {
                $consoTotalNucleaire = $consoTotalEolien + $quarter->getNucleaire();
                $consoTotalEolien = $consoTotalEolien + $quarter->getEolien();
                $consoTotalPhotovoltaique = $consoTotalPhotovoltaique + $quarter->getPhotovoltaique();
                $consoTotalHydraulique = $consoTotalHydraulique + $quarter->getHydraulique();
                $consoTotalFlamme = $consoTotalFlamme + $quarter->getFlamme();
            }
        }
        $yearData = new Year($this->getYearReference(),$consoTotalNucleaire, $consoTotalEolien,$consoTotalPhotovoltaique, $consoTotalFlamme, $consoTotalHydraulique, null);

        var_dump($yearData);
    }
}
