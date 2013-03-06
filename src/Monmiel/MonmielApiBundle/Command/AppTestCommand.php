<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppTestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("monmiel:test:test1")
            ->setDescription("Extract Data from RTE and populate Riak");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

       $tmp = new \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1();

       $tmpQ1 = new \Monmiel\MonmielApiModelBundle\Model\Quarter(15,"2012-03-04",15,0,0,10,60,0);
       $tmpQ2 = new \Monmiel\MonmielApiModelBundle\Model\Quarter(5,"2012-03-04",5,0,0,10,60,20);

       $tmpQ = array($tmpQ1,$tmpQ2);



       $tmpQQ=$tmp->transformeTotalToConsoTher($tmpQ,1200,1400);

       foreach($tmpQQ as $value){

           echo $value->getConsoTotal() . "\n";

       }

       //echo    $tmp->transformeTotalCalcul(60,1200,1400);

    }
}
