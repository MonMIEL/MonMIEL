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
     * @var \Monmiel\MonmielApiBundle\Services\ParcService\ParcService $parc
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
        $this->parc=$this->getContainer()->get("monmiel.parc.service");

        $userConsoMesure = new Mesure(478, \Monmiel\Utils\ConstantUtils::TERAWATT);
        $actualConsoMesure = new Mesure(478, \Monmiel\Utils\ConstantUtils::TERAWATT);

        $this->transformers->setConsoTotalActuel($actualConsoMesure);
        $this->transformers->setConsoTotalDefinedByUser($userConsoMesure);

        $refYear = $this->createRefYearObject();
        $targetYear = $this->createTargetYearObject();

        $this->transformers->setReferenceYear($refYear);
        $this->transformers->setTargetYear($targetYear);

        $this->parc->setTargetParcPower($targetYear);
        $this->parc->setRefParcPower($refYear);
        $targetParcPower = $this->parc->getTargetParcPower();
        $refParcPower = $this->parc->getRefParcPower();
        $this->repartition->setReferenceYear($refYear);
        $this->repartition->setTargetYear($targetYear);
        $this->repartition->setReferenceParcPower($refParcPower);
        $this->repartition->setTargetParcPower($targetParcPower);
      //  $this->stopWatch->stop("init");
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


        for ($i = 1; $i < 363; $i++) {
            $day = $this->repartition->get($i);
        }
        $computedYear = $this->repartition->getComputedYear();

        $parc = $this->parc->getTargetParcPower();
        echo "Nombre d'heure réelle dans l'année: ".$computedYear->getNbInterval();

    //    echo($this->repartition->getComputedYear()->toString());
    }
}
