<?php

namespace Monmiel\MonmielApiBundle\Command;

use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Monmiel\MonmielApiModelBundle\Model\Day;

use Monmiel\MonmielApiModelBundle\Model\Mesure;

use Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1;
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
        $item = $client->gets(1);
        var_dump($item);
    }
}
