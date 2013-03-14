<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;

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
        }
        return self::$instance;
    }

    //Méthode permettant de vérifier si les valeurs en paramètre sont les max
    public function setMaxValueFlamme($solde){
        $this->flamme->setMaxFlamme($solde);
    }

    //Retourne le parc final (pour le moment que l'énergie, pas de réacteur par exemple
    /**
     * @var $year Year
     * @return ParcFinal
     */
    public function getParc(){

        //On recupere l'energie nécessaire pour chaque énergie
        $ParcNuc=$this->nucleaire->getParcNuclear();
        $ParcEol=$this->eolien->getParcEolien();
        $ParcHyd=$this->hydraulique->getParcHydraulic();
        $ParcPv=$this->pv->getParcPv();
        $ParcFlamme=$this->flamme->getParcFlamme();

        $ParcAut=null;
        //$this->autres->getParcAutre();

        //Creation d'un object ParcFinal pour ne retourner que ce qui est necessaire
        $newParc=new ParcFinal($ParcNuc,$ParcEol,$ParcHyd,$ParcPv,$ParcFlamme,$ParcAut);
        return $newParc;
    }

    /**
     * @var $year Year
     */
    public function getPower(){

        return new Power($this->flamme->getPowerFlamme(),$this->hydraulique->getPowerHydraulic(),0,$this->nucleaire->getPowerNuclear(),0,$this->pv->getPowerPv(),0,$this->eolien->getPowerEolien());

    }

    //Le parametre intervalle correspond a l'interval de temps durant lequel a été faites la consommation ( 8760 correspond à 1 année)
    private function calculateWattHour2Power($wattHour,$interval){
        return $wattHour/$interval;
    }

    //Define the power of Nuclear, PV, Wind, Photovoltaic
    /**
     * @param $year Year
     */

    public function setPowerForEachEnergy($year,$interval){

        $percentNuclear=$year->getConsoTotalNucleaire()/$year->getConsoTotalGlobale();
        $this->nucleaire->setPowerNuclear(($this->calculateWattHour2Power($year->getConsoTotalNucleaire(),$interval)),$percentNuclear);
        $this->eolien->setPowerEolien($this->calculateWattHour2Power($year->getConsoTotalEolien(),$interval));
        $this->pv->setPowerPv($this->calculateWattHour2Power($year->getConsoTotalPhotovoltaique(),$interval));
        $this->hydraulique->setPowerHydraulic($this->calculateWattHour2Power($year->getConsoTotalHydraulique(),$interval));
        $this->flamme->setPowerFlamme();
        //$this->autres->setPowerAutre($power->getOther());
    }

}