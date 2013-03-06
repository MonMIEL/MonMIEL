<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1;
use Monmiel\MonmielApiModelBundle\Model\Mesure;

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
        /**
         * @var $transformersService TransformersV1
         */
        $transformersService = $this->getContainer()->get("monmiel.transformers.service");
        $transformersService->setConsoActuel(new Mesure(700));
        $transformersService->setConsoTotalDefinedByUser(new Mesure(800));
        $days = array();
        for ($i = 1; $i <= 365; $i++) {
            $day = $transformersService->get($i);
            $days[] = $day;
        }
    }
}
