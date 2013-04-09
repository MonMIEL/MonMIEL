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
            ->setName("monmiel:test:daoclient")
            ->setDescription("Extract Data from RTE and populate Riak");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $dao  \Monmiel\MonmielApiBundle\Dao\DaoClientService */
        $dao = $this->getContainer()->get("monmiel.dao.client");

        var_dump($dao->get("5"));exit;

    }
}
