<?php

namespace Monmiel\MonmielApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Monmiel\MonmielApiModelBundle\Model\Year;
use Monmiel\MonmielApiModelBundle\Model\Mesure;
class RepartitionTestCommand extends ContainerAwareCommand
{
    /**
     * @var \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1 $transformers
     */
    public $transformers;

    /**
     * @var \Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1 $repartition
     */
    public $repartition;
    /**
     * @var \Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService $parc
     */
    public $parc;

    protected function configure()
    {
        $this
            ->setName("monmiel:test:perf")
            ->setDescription("Extract Data from RTE and populate Riak");
    }

    public function init()
    {
        $this->transformers = $this->getContainer()->get("monmiel.transformers.v1.service");
        $this->repartition=$this->getContainer()->get("monmiel.repartition.service");
        $this->parc=$this->getContainer()->get("monmiel.facility.service");

        $userConsoMesure = new Mesure(478, \Monmiel\Utils\ConstantUtils::TERAWATT);
        $actualConsoMesure = new Mesure(478, \Monmiel\Utils\ConstantUtils::TERAWATT);

        $this->transformers->setConsoTotalActuel($actualConsoMesure);
        $this->transformers->setConsoTotalDefinedByUser($userConsoMesure);

        $refYear = $this->createRefYearObject();
        $targetYear = $this->createTargetYearObject();

        var_dump($targetYear);

        $this->transformers->setReferenceYear($refYear);
        $this->transformers->setTargetYear($targetYear);

        $targetParcPower = $this->parc->getPower($targetYear);
        $refParcPower = $this->parc->getPower($refYear);
        $this->repartition->setReferenceYear($refYear);
        $this->repartition->setTargetYear($targetYear);
        $this->repartition->setReferenceParcPower($refParcPower);
        $this->repartition->setTargetParcPower($targetParcPower);
    }

    public function createTargetYearObject()
    {
        $totalNuclear = 150 * 1000000;
        $totalPhoto = 150 * 1000000;
        $totalEol = 150 * 1000000;
        return new Year(2050, $totalNuclear, $totalEol, $totalPhoto, 0, 151998661/4, 0);
    }

    public function createRefYearObject()
    {
        $totalNuclear = 150 * 1000000;
        $totalPhoto = 150 * 1000000;
        $totalEol = 150 * 1000000;
        return new Year(2011, $totalNuclear, $totalEol, $totalPhoto, 0, 151998661/4, 0);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stopwatch = new Stopwatch();
// Start event named 'eventName'
   $stopwatch->start('eventName');

      //  echo "\n start time" .     $event->getStartTime();
// ... some code goes here

        $debut = microtime(true);
        $occ=1;
        /**       @var $repartitionService RepartitionServiceV1 */
        $repartitionService = $this->repartition;//$this->getContainer()->get("monmiel.repartition.service");

        /**
         * @var \Monmiel\MonmielApiBundle\Controller\SimulationV1Controller
         */
        //$control = $this->getContainer()->get("monmiel.simulation.controller");

      //  $control->init();

        $this->init();

        $days = array();


        for ($boucle=1; $boucle<=$occ; $boucle++)
        {
        for ($i = 1; $i <= 10; $i++) {
            /*
             * @var Day $val
             */
           $val = $this->repartition->get($i);

        }
        }
        $fin = microtime(true);

        $result = $fin - $debut;
        echo "\n debut:   " . $debut;
        echo " \n fin:" . $fin;

        echo "\n \n";

        echo "le resultat final est: " . $result;
        echo "\n \n \n";


        $event = $stopwatch->stop('eventName');
        echo "\n end time" . $event->getEndTime();
        echo "\n start time" . $event->getStartTime();

 echo (" \n \n\n\n");
        echo "Fin :";
    //    echo($this->repartition->getComputedYear()->toString());
    }
}
