<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1;
use \Monmiel\MonmielApiModelBundle\Model\Day;
use \Monmiel\MonmielApiModelBundle\Model\Quarter;
class TestTransCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("monmiel:test:test1")
            ->setDescription("Extract Data from RTE and populate Riak");
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        for($i = 1; $i<365; $i++){
            $dao = $this->getContainer()->get("monmiel.dao.riak");
            $day = $dao->getDayConso($i);

            echo("size _________________:"); echo sizeof($day->getQuarters());
            echo "------------------ before \n";
            $indexBefore = 0;
            foreach ($day->getQuarters() as $val) {
               echo("--------------- index :".$indexBefore." conso :".$val->getConsoTotal()."____________ \n");
                $indexBefore ++;
            }

            $t = new \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1();
            $consoActual = new \Monmiel\MonmielApiModelBundle\Model\Mesure(600);
            $consoInput = new \Monmiel\MonmielApiModelBundle\Model\Mesure(800);
            $dayRetour = $t->updateConsoTotalQuartersForDayByConsoTotalActualAndConsoDefineByUser($day,$consoActual,$consoInput);
            //$dayRetour = $t->getDayUpdatedByDayIdActualConsoAndInputConso(1,$consoActual,$consoInput);
            $t->setConsoActual($consoActual);
            $t->setConsoInput($consoInput);
            //$dayRetour = $t->get(1);
            echo "------------------ after \n";
            $index = 0;
            foreach ($dayRetour->getQuarters() as $val) {
                echo("--------------- index :".$index." conso :".$val->getConsoTotal()."____________ \n");
                $index ++;
            }
            echo("size _________________:"); echo sizeof($dayRetour->getQuarters()); echo("____________________end \n");
        }
    }
}
