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
class TestTransCommand extends ContainerAwareCommand
{


    /**
     * @var $facility ComputeFacilityService
     */
    protected  $facility;

    protected function configure()
    {
        $this
            ->setName("monmiel:test:test1")
            ->setDescription("Extract Data from RTE and populate Riak");


    }

    protected function execute(InputInterface $input, OutputInterface $output){

          $this->facility = $this->getContainer()->get("monmiel.facility.service");

    /*
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
    */

        /*
        $q1=new Quarter("2013-01-02",100,15,15,10,60,0,0,0,0,0,0,0,0);
        $q2=new Quarter("2013-01-02",100,5,5,10,60,0,0,0,0,0,0,0,0);
        $q3=new Quarter("2013-01-02",110,15,20,10,60,0,0,0,0,0,0,0,0);
        $q4=new Quarter("2013-01-02",93,8,0,10,60,0,0,0,0,0,0,0,0);

        $tmp = array();

        array_push($tmp,$q1);
        array_push($tmp,$q2);
        array_push($tmp,$q3);
        array_push($tmp,$q4);


        $day = new Day('2012-01-06',$tmp);

        $t = new \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1();

        $consoAct = new \Monmiel\MonmielApiModelBundle\Model\Mesure(1200);

        $inputConso = new \Monmiel\MonmielApiModelBundle\Model\Mesure(1400);

        $result = $t->updateConsoTotalQuartersForDayByConsoTotalActualAndConsoDefineByUser($day,$consoAct,$inputConso);

        echo("size _________________:"); echo sizeof($day->getQuarters());
        echo "------------------ before \n";
        $indexBefore = 0;
        foreach ($day->getQuarters() as $val) {
            echo("--------------- index :".$indexBefore." conso :".$val->getConsoTotal()."____________ \n");
            $indexBefore ++;
        }

        echo "------------------ after \n";
        $index = 0;
        foreach ($result->getQuarters() as $val) {
            echo("--------------- index :".$index." conso :".$val->getConsoTotal()."____________ \n");
            $index ++;
        }
        echo("size _________________:"); echo sizeof($result->getQuarters()); echo("____________________end \n");

    */

        /*
    $askUser = new AskUser(6000,8000,0,67540,0,1568,0,25686,3368);

        $t = new \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1();

        $t->setAskUser($askUser);

        $p=$t->getPowerTarget();

        echo $p->getFlame() . "\n";

        echo $p->getHydraulic() . "\n";

        echo $p->getPhotovoltaic() . "\n";

        echo $p->getWind() . "\n";
*/


        $q1=new Quarter("2013-01-02",5000,0,0,0,5000,0,0,0,0,0,0,0,0);
        $q2=new Quarter("2013-01-02",20000,0,0,0,20000,0,0,0,0,0,0,0,0);

        $tmp = array();

        array_push($tmp,$q1);
        array_push($tmp,$q2);

        $day = new Day('2012-01-02',$tmp);

        $yearRef = new \Monmiel\MonmielApiModelBundle\Model\Year("1",100000000,0,0,0,0,0,100000000);

        $yearTarget = new \Monmiel\MonmielApiModelBundle\Model\Year("2",150000000,0,0,0,0,0,150000000);


        $powerRef=$this->facility->getPower($yearRef);

        echo "power ref" . "\n";
        var_dump($powerRef);

        $powerTarget=$this->facility->getPower($yearTarget);

        echo "power target" . "\n";
        var_dump($powerTarget);

        $transformers = new TransformersV1();


        $transformers->setConsoTotalActuel(new \Monmiel\MonmielApiModelBundle\Model\Mesure(100,\Monmiel\Utils\ConstantUtils::TERAWATT_HOUR));
        $transformers->setConsoTotalDefinedByUser(150,\Monmiel\Utils\ConstantUtils::TERAWATT_HOUR);

        $transformers->setReferenceYear($yearRef);
        $transformers->setTargetYear($yearTarget);


        $dayTransf=$transformers->UpdateConsoTotalForQuatersForDay($day);











        $repartition = new \Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1();

        $repartition->setReferenceParcPower($powerRef);
        $repartition->setTargetParcPower($powerTarget);


        /**
         * @var Day $tmpDay
         */
        $tmpDay=$repartition->computeMixedTargetDailyConsumptionTest($dayTransf);

        var_dump($tmpDay);




    }

}
