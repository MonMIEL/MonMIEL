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
use Monmiel\MonmielApiModelBundle\Model\AskUser;
use Monmiel\MonmielApiModelBundle\Model\Power;
use Monmiel\MonmielApiModelBundle\Model\Mesure;
use Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService;
use Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1;

class TestTransCommand extends ContainerAwareCommand
{


    /**
     * @var $facility ComputeFacilityService
     */
    protected  $facility;
    /**
     * @var $control \Monmiel\MonmielApiBundle\Controller\SimulationV1Controller
     */
    protected $control;

    protected function configure()
    {
        $this
            ->setName("monmiel:test:test1")
            ->setDescription("Extract Data from RTE and populate Riak");


    }

    protected function execute(InputInterface $input, OutputInterface $output){

        $this->facility = $this->getContainer()->get("monmiel.facility.service");
        $this->transformers= $this->getContainer()->get("monmiel.transformers.v1.service");
        $this->repartition= $this->getContainer()->get("monmiel.repartition.service");



        $q1=new Quarter("2013-01-01",5000,0,0,0,5000,0,0,0,0,0,0,0,0);
        $q2=new Quarter("2013-01-02",20000,0,0,0,20000,0,0,0,0,0,0,0,0);
        $q3=new Quarter("2013-01-03",15000,0,0,0,15000,0,0,0,0,0,0,0,0);

        $tmp = array();

        array_push($tmp,$q1);
        array_push($tmp,$q2);
        array_push($tmp,$q3);
        $day = new Day('2012-01-02',$tmp);

        $yearRef = new \Monmiel\MonmielApiModelBundle\Model\Year("1",100000000,0,0,0,0,0,100000000);

        $yearTarget = new \Monmiel\MonmielApiModelBundle\Model\Year("2",150000000,0,0,0,0,0,150000000);


        $powerRef=$this->facility->getPower($yearRef);



        $powerTarget=$this->facility->getPower($yearTarget);


        $this->transformers->setConsoTotalActuel(new \Monmiel\MonmielApiModelBundle\Model\Mesure(100,\Monmiel\Utils\ConstantUtils::TERAWATT));
        $this->transformers->setConsoTotalDefinedByUser(new Mesure(150,\Monmiel\Utils\ConstantUtils::TERAWATT));

        $this->transformers->setReferenceYear($yearRef);
        $this->transformers->setTargetYear($yearTarget);


        $dayTransf=$this->transformers->UpdateConsoTotalForQuatersForDay($day);



        $this->repartition->setReferenceYear($yearRef);
        $this->repartition->setTargetYear($yearTarget);
        $this->repartition->setReferenceParcPower($powerRef);
        $this->repartition->setTargetParcPower($powerTarget);


        /**
         * @var Day $tmpDay
         */
        $tmpDay=$this->repartition->computeMixedTargetDailyConsumption($dayTransf);

        $yearComputed=$this->repartition->getComputedYear();
        echo "year target" . "\n";
        var_dump($yearComputed);
        /*echo "power ref" . "\n";
        var_dump($powerRef);

        echo "power target" . "\n";
        var_dump($powerTarget);*/

        var_dump($tmpDay);
        //echo "Répartition des puissances après simulation \n";
        //var_dump($newPower);




    }

}
