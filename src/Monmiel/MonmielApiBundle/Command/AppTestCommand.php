<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppTestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("monmiel:test:dao")
            ->setDescription("Extract Data from RTE and populate Riak");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $client  \Monmiel\MonmielApiBundle\Dao\DaoClientService */
        $client = $this->getContainer()->get("monmiel.dao.client");
        for ($i = 1; $i < 360 ; $i++) {
            $item = $client->gets($i);
            var_dump($item->getKey());
        }
    }
}
