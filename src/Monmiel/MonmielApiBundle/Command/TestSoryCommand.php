<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Monmiel\MonmielApiModelBundle\Model\Quarter;
use Monmiel\MonmielApiModelBundle\Model\Day;

class TestSoryCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("monmiel:test:dao")
            ->setDescription("Extract Data from RTE and populate Riak");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dao = $this->getContainer()->get("monmiel.dao.riak");
        $day = $dao->getDayConso(1);
        var_dump($day);
    }

}
