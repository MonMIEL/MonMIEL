<?php
namespace Monmiel\MonmielApiBundle\Tests\Services\FacilityService;

use Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1;
use Monmiel\MonmielApiBundle\Tests\BaseTestCase;
use Monmiel\MonmielApiModelBundle\Model\Day;
use Monmiel\MonmielApiModelBundle\Model\Quarter;
use Monmiel\MonmielApiModelBundle\Model\Power;
use Monmiel\MonmielApiModelBundle\Model\Year;
use Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService;

/**
 * Created by JetBrains PhpStorm.
 * User: Dadoo
 * Date: 12/03/13
 * Time: 09:28
 * To change this template use File | Settings | File Templates.
 */
class RepartitionServiceTest extends BaseTestCase
{
    /**
     * @var $repartitionService RepartitionServiceV1
     */
    protected $repartitionService;

    public function setup()
    {
        $this->repartitionService = new RepartitionServiceV1();
        $this->repartitionService->setTargetYear(new Year(1,0,0,0,0,0,0));
        $this->repartitionService->setFacilityService(new ComputeFacilityService());
    }

    /**
     * Test de la méthode computeMaxProductionPerEnergy du service RepartitionService
     * @test
     */
    public function testComputeMaxProductionPerEnergy(){
        /*************************
         * Début paramètres du test
         *************************/
        //Puissances de l'année de référence
        $powerRefNuclear = 400;
        $powerRefHydraulic = 300;
        $powerRefPhotovoltaique = 100;
        $powerRefEolian = 200;

        //Puissances de l'année cible
        $powerTargetNuclear = 1000;
        $powerTargetHydraulic = 50;
        $powerTargetPhotovoltaique = 200;
        $powerTargetEolian = 300;

        /**
         * @var $day Day
         */
        $day = $this->getDayObject();

       /**
        * @var $quarter Quarter
        */
        $quarter = $day->getQuarter(1);

        /**
         * Valeurs vraies pour le test
         * @var $expectedTrue Quarter
         */
        $expectedTrue = new Quarter($quarter->getDate(),$quarter->getConsoTotal(),0,0,0,0,0,0,0);
        $expectedTrue->setEolien($powerTargetEolian*$quarter->getEolien()/$powerRefEolian);
        $expectedTrue->setPhotovoltaique($powerTargetPhotovoltaique*$quarter->getPhotovoltaique()/$powerRefPhotovoltaique);
        $expectedTrue->setNucleaire($powerTargetNuclear);
        $expectedTrue->setHydraulique($powerTargetHydraulic);

        /*************************
         * Fin paramètres du test
         *************************/

        $this->repartitionService->setReferenceParcPower(new Power(0,$powerRefHydraulic,0,$powerRefNuclear,0,$powerRefPhotovoltaique,0,$powerRefEolian));
        $this->repartitionService->setTargetParcPower(new Power(0,$powerTargetHydraulic,0,$powerTargetNuclear,0,$powerTargetPhotovoltaique,0,$powerTargetEolian));

        /**
         * @var $quarterActual Quarter
         */
        $resultat = $this->repartitionService->computeMaxProductionPerEnergy($quarter);

        /*
         * Test de comparaison avec des valeurs vraies
         */
        $this->assertEquals($expectedTrue->getDate(), $resultat->getDate(),"La date du quart d'heure mis a jour doit etre la meme que celui d'orgine");
        $this->assertEquals($expectedTrue->getConsoTotal(), $resultat->getConsoTotal(), "La consommation totale du quart d'heure mis a jour doit etre la meme que celui d'origine");
        $this->assertEquals($expectedTrue->getNucleaire(),$resultat->getNucleaire(), "La capacité de production du nucleaire est fausse");
        $this->assertEquals($expectedTrue->getHydraulique(),$resultat->getHydraulique(), "La capacité de production de l'hydraulique est fausse");
        $this->assertEquals($expectedTrue->getPhotovoltaique(),$resultat->getPhotovoltaique(), "La capacité de production du photovoltaique est fausse");
        $this->assertEquals($expectedTrue->getEolien(), $resultat->getEolien(), "La capacité de production de l'eolien est fausse");
    }


    /**
     * Test de la méthode computeMixedTargetDailyConsumption du service RepartitionService
     * @test
     */
    public function testComputeMixedTargetDailyConsumption(){
        /*************************
         * Début paramètres du test
         *************************/
        /**
         * @var $day Day
         */
        $day = $this->getDayObject();

        //Puissances de l'année de référence
        $powerRefNuclear = 400;
        $powerRefHydraulic = 300;
        $powerRefPhotovoltaique = 100;
        $powerRefEolian = 200;

        //Puissances de l'année cible
        $powerTargetNuclear = 500;
        $powerTargetHydraulic = 1500;
        $powerTargetPhotovoltaique = 200;
        $powerTargetEolian = 300;

        /**
         * @var $expectedTrue Quarter
         */
        $expectedTrue;
        /**
         * @var $toTest Quarter
         */
        $toTest;

        /*************************
         * Fin paramètres du test
         *************************/

        $this->repartitionService->setReferenceParcPower(new Power(0,$powerRefHydraulic,0,$powerRefNuclear,0,$powerRefPhotovoltaique,0,$powerRefEolian));
        $this->repartitionService->setTargetParcPower(new Power(0,$powerTargetHydraulic,0,$powerTargetNuclear,0,$powerTargetPhotovoltaique,0,$powerTargetEolian));

        /**
         * @var $resultat Day
         */
        $resultat = $this->repartitionService->computeMixedTargetDailyConsumption($day);

        //Verification du 1er quart d'heure

        //Eolien > ConsoTotal
        $expectedTrue = $day->getQuarter(1);
        $toTest = $resultat->getQuarter(1);

        $valueEnergy = $expectedTrue->getConsoTotal();
        $expectedTrue->setEolien($valueEnergy);
        $this->assertEquals($expectedTrue->getEolien(),$toTest->getEolien(),"La consommation de l'eolien du quart d'heure est de ".$toTest->getEolien()." alors qu'il doit etre a ".$expectedTrue->getEolien());

        //Photovoltaique > ConsoTotal
        $expectedTrue = $day->getQuarter(2);
        $toTest = $resultat->getQuarter(2);

        $eolian = $powerTargetEolian*$expectedTrue->getEolien()/$powerRefEolian;
        $valueEnergy = $expectedTrue->getConsoTotal() - $eolian;
        $expectedTrue->setPhotovoltaique($valueEnergy);
        $this->assertEquals($expectedTrue->getPhotovoltaique(),$toTest->getPhotovoltaique(),"La consommation du photovoltaique du quart d'heure est de ".$toTest->getPhotovoltaique()." alors qu'il doit etre a ".$expectedTrue->getPhotovoltaique());

        //Hydraulique > ConsoTotal
        $expectedTrue = $day->getQuarter(3);
        $toTest = $resultat->getQuarter(3);

        $eolian = $powerTargetEolian*$expectedTrue->getEolien()/$powerRefEolian;
        $photovoltaic = $powerTargetPhotovoltaique*$expectedTrue->getPhotovoltaique()/$powerRefPhotovoltaique;
        $valueEnergy = $expectedTrue->getConsoTotal() - $eolian - $photovoltaic;
        $expectedTrue->setHydraulique($valueEnergy);

        $this->assertEquals($expectedTrue->getHydraulique(),$toTest->getHydraulique(),"La consommation de l'hydraulique du quart d'heure est de ".$toTest->getHydraulique()." alors qu'il doit etre a ".$expectedTrue->getHydraulique());

        //Nucleaire > ConsoTotal
        $expectedTrue = $day->getQuarter(4);
        $toTest = $resultat->getQuarter(4);

        $eolian = $powerTargetEolian*$expectedTrue->getEolien()/$powerRefEolian;
        $photovoltaic = $powerTargetPhotovoltaique*$expectedTrue->getPhotovoltaique()/$powerRefPhotovoltaique;
        $hydraulic = $powerTargetHydraulic;
        $valueEnergy = $expectedTrue->getConsoTotal() - $eolian - $photovoltaic - $hydraulic;
        $expectedTrue->setNucleaire($valueEnergy);
        $this->assertEquals($expectedTrue->getNucleaire(),$toTest->getNucleaire(),"La consommation du nucleaire du quart d'heure est de ".$toTest->getNucleaire()." alors qu'il doit etre a ".$expectedTrue->getNucleaire());

        //Flamme
        $expectedTrue = $day->getQuarter(5);
        $toTest = $resultat->getQuarter(5);

        $eolian = $powerTargetEolian*$expectedTrue->getEolien()/$powerRefEolian;
        $photovoltaic = $powerTargetPhotovoltaique*$expectedTrue->getPhotovoltaique()/$powerRefPhotovoltaique;
        $hydraulic = $powerTargetHydraulic;
        $nuclear = $powerTargetNuclear;

        $valueEnergy = $expectedTrue->getConsoTotal() - $eolian - $photovoltaic - $hydraulic - $nuclear;
        $expectedTrue->setFlamme($valueEnergy);
        $this->assertEquals($expectedTrue->getFlamme(),$toTest->getFlamme(),"La consommation de flamme du quart d'heure est de ".$toTest->getFlamme()." alors qu'il doit etre a ".$expectedTrue->getFlamme());
    }

    /**
     * @return Day
     */
    public function getDayObject()
    {
        $date1 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 00:00:00");
        $date2 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 00:15:00");
        $date3 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 00:30:00");
        $date4 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 00:45:00");
        $date5 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 01:00:00");
        $date6 = date_create_from_format("Y-m-d H:i:s", "2011-01-01 01:15:00");

        $object = new Day($date1);

        $q1 = new Quarter($date1, 1026, 500, 100, 0, 20, 344, 62, 0); //Test de ComputeMaxProductionPerEnergy

        //Différents quarts d'heure pour tester computeMixedTargetDailyConsumption avec différents cas
        $q2 = new Quarter($date2, 2000, 2000, 0, 0, 0, 0, 0, 0); //Eolien
        $q3 = new Quarter($date3, 2000, 500, 0, 0, 0, 1500, 0, 0); //Photovoltaique
        $q4 = new Quarter($date4, 2000, 100, 0, 1500, 0, 400, 0, 0); //Hydraulique
        $q5 = new Quarter($date5, 2000, 200, 0, 500, 1000, 0, 300, 0); //Nucleaire
        $q6 = new Quarter($date6, 10000, 200, 0, 300, 500, 0, 50, 0); //Flamme

        $object->addQuarters($q1);
        $object->addQuarters($q2);
        $object->addQuarters($q3);
        $object->addQuarters($q4);
        $object->addQuarters($q5);
        $object->addQuarters($q6);


        return $object;
    }
}