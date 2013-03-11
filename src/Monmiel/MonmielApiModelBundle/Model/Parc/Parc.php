<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:05
 * To change this template use File | Settings | File Templates.
 */
use Monmiel\MonmielApiModelBundle\Model\Parc\Nuclear;
use Monmiel\MonmielApiModelBundle\Model\Parc\Eolien;
use Monmiel\MonmielApiModelBundle\Model\Parc\Hydraulic;
use Monmiel\MonmielApiModelBundle\Model\Parc\Pv;
use Monmiel\MonmielApiModelBundle\Model\Parc\Autres;
use Monmiel\MonmielApiModelBundle\Model\Parc\Flamme;
use Monmiel\MonmielApiModelBundle\Model\Parc\ParcFinal;

use Monmiel\MonmielApiModelBundle\Model\Year;
use Monmiel\MonmielApiModelBundle\Model\Power;



class Parc{

    private static $instance =null;

    private $nucleaire;
    private $eolien;
    private $pv;
    private $hydraulique;
    private $flamme;
    private $autres;

    private function __construct(){
        $this->nucleaire= new Nuclear();
        $this->eolien= new Eolien();
        $this->pv=new Pv();
        $this->hydraulique=new Hydraulic();
        $this->flamme=new Flamme();
        $this->autres=new Autres();

    }


    //Pattern singleton, pour ne créer qu'une seule fois le parc afin de ne pas remettre à zéro les attributs chaque jour
    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new Parc();
            echo 'Creation du parc initial';
        }
        return self::$instance;
    }

    //Méthode permettant de vérifier si les valeurs en paramètre sont les max
    public function setMaxValueFlamme($solde){

        $this->flamme->setMaxFlamme($solde);

    }


    //Met a jour le facteur de charge et le taux de disponibilité pour le nucléaire, l'éolien, le pv et l'hydraulique en fonction du mix final
    protected function DefineRate($mixFinal){
        //$this->nucleaire->setFacteurChargeNuclear($mixFinal);
        $this->eolien->setFacteurChargeEolien($mixFinal);
        $this->pv->setFacteurChargePv($mixFinal);
        $this->hydraulique->setFacteurChargeHydraulique($mixFinal);
        $this->flamme->setFacteurChargeFlamme($mixFinal);

        //$this->nucleaire->setTauxDisponibiliteNuclear($mixFinal);
        $this->eolien->setTauxDisponibiliteEolien($mixFinal);
        $this->pv->setTauxDisponibilitePv($mixFinal);
        $this->hydraulique->setTauxDisponibiliteHydraulique($mixFinal);
        $this->flamme->setTauxDisponibiliteFlamme($mixFinal);
    }

    //Retourne le parc final (pour le moment que l'énergie, pas de réacteur par exemple
    public function getParc($mixFinal, $power){
        //On défini le taux de disponibilité et le facteur de charge pour chacune des energies
        //$this->DefineRate($mixFinal);
        $this->setPowerForEachEnergy($power);
        //On recupere l'energie nécessaire pour chaque énergie
        $PuisNuc=$this->nucleaire->getPowerNuclear();
        $PuisEol=$this->eolien->getPowerEolien();
        $PuisHyd=$this->hydraulique->getPowerHydraulic();
        $PuisPv=$this->pv->getPowerPv();
        $PuisFlamme=$this->flamme->getPowerFlamme();
        $PuisAut=null;
            //$this->autres->getValueAutre();

        //On recupere l'energie nécessaire pour chaque énergie
        $ParcNuc=$this->nucleaire->getParcNuclear();
        $ParcEol=$this->eolien->getParcEolien();
        $ParcHyd=$this->hydraulique->getParcHydraulic();
        $ParcPv=$this->pv->getParcPv();
        $ParcFlamme=$this->flamme->getParcFlamme();
        $ParcAut=null;
            //$this->autres->getParcAutre();

        //Creation d'un object ParcFinal pour ne retourner que ce qui est necessaire
        $newParc=new ParcFinal(($PuisNuc/$this->nucleaire->getTauxDisponibiliteNuclear()),($PuisEol/$this->eolien->getTauxDisponibiliteEolien()),($PuisHyd/$this->hydraulique->getTauxDisponibiliteHydraulique()),($PuisPv/$this->pv->getTauxDisponibilitePv()),($this->flamme->getTauxDisponibiliteFlamme()),($PuisAut/$this->autres->getTauxDisponibiliteAutre()),$ParcNuc,$ParcEol,$ParcHyd,$ParcPv,$ParcFlamme,$ParcAut);
        return $newParc;
    }

    private function calculateWattHour2Power($wattHour){

        return $wattHour/(365*24);
    }


    //Define the power of Nuclear, PV, Wind, Photovoltaic
    /**
     * @param $year Year
     */
    public function setPowerForEachEnergy($year){

        $this->nucleaire->setPowerNuclear($this->calculateWattHour2Power($year->getConsoTotalNucleaire()),($year->getConsoTotalNucleaire()/$year->getConsoTotalGlobale()));
        $this->eolien->setPowerEolien($this->calculateWattHour2Power($year->getConsoTotalEolien()));
        $this->pv->setPowerPv($this->calculateWattHour2Power($year->getConsoTotalPhotovoltaique()));
        $this->hydraulique->setPowerHydraulic($this->calculateWattHour2Power($year->getConsoTotalHydraulique()));
        $this->flamme->setPowerFlamme();
        //$this->autres->setPowerAutre($power->getOther());

    }

    /**
     *
     */
    public function getPower(){
        return new Power(0,$this->hydraulique->getPowerHydraulic(),0,$this->nucleaire->getPowerNuclear(),0,$this->pv->getPowerPv(),0,$this->eolien->getPowerEolien());
    }






}


