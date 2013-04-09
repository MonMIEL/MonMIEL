<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;

use Monmiel\MonmielApiModelBundle\Model\Parc\Nuclear;
use Monmiel\MonmielApiModelBundle\Model\Parc\Eolien;
use Monmiel\MonmielApiModelBundle\Model\Parc\Hydraulic;
use Monmiel\MonmielApiModelBundle\Model\Parc\Pv;
use Monmiel\MonmielApiModelBundle\Model\Parc\Flamme;

use Monmiel\MonmielApiModelBundle\Model\Year;
use Monmiel\MonmielApiModelBundle\Model\Power;



class GlobalParc{

    /**
     * @var Nuclear $nucleaire
     */
    protected $nucleaire;

    /**
     * @var Eolien $eolien
     */
    protected $eolien;

    /**
     * @var Pv $pv
     */
    protected $pv;

    /**
     * @var Hydraulic $hydraulique
     */
    protected $hydraulique;

    /**
     * @var Flamme $flamme
     */
    protected $flamme;

    /**
     * @var Step $step
     */

    protected $step;

    /**
     * @var Import $import
     */

    protected $import;

    /**
     * @param $power Power
     * @param $nukePercent float
     */
    public function __construct($power, $nukePercent)
    {
        $this->nucleaire= new Nuclear($power->getNuclear(), $nukePercent);
        $this->eolien= new Eolien($power->getWind());
        $this->pv=new Pv($power->getPhotovoltaic());
        $this->hydraulique=new Hydraulic($power->getHydraulic());
        $this->flamme=new Flamme();
        $this->step= new Step($power->getStep());
        $this->import=new Import($power->getImport());
    }


    //Méthode permettant de vérifier si les valeurs en paramètre sont les max
    public function submitFlamePower($flamePower){
        $this->flamme->setPower($flamePower);
    }

    //Méthode permettant de vérifier si les valeurs en paramètre sont les max
    public function submitImportPower($importPower){
        $this->import->setPower($importPower);
    }

    /**
     * @var $year Year
     */
    public function getPower(){

        return new Power(
            $this->flamme->getPower(),
            $this->hydraulique->getPower(),
            $this->import->getPower(),
            $this->nucleaire->getPower(),
            0,
            $this->pv->getPower(),
            $this->step->getPower(),
            $this->eolien->getPower()
        );
    }
}