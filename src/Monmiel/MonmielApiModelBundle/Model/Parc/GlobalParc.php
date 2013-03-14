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
    }


    //Méthode permettant de vérifier si les valeurs en paramètre sont les max
    public function submitFlamePower($flamePower){
        $this->flamme->setMaxFlamme($flamePower);
    }


    /**
     * @var $year Year
     */
    public function getPower(){

        return new Power(
            $this->flamme->getPower(),
            $this->hydraulique->getPower(),
            0,
            $this->nucleaire->getPower(),
            0,
            $this->pv->getPower(),
            0,
            $this->eolien->getPower()
        );
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Parc\Eolien $eolien
     */
    public function setEolien($eolien)
    {
        $this->eolien = $eolien;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Parc\Eolien
     */
    public function getEolien()
    {
        return $this->eolien;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Parc\Flamme $flamme
     */
    public function setFlamme($flamme)
    {
        $this->flamme = $flamme;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Parc\Flamme
     */
    public function getFlamme()
    {
        return $this->flamme;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Parc\Hydraulic $hydraulique
     */
    public function setHydraulique($hydraulique)
    {
        $this->hydraulique = $hydraulique;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Parc\Hydraulic
     */
    public function getHydraulique()
    {
        return $this->hydraulique;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Parc\Nuclear $nucleaire
     */
    public function setNucleaire($nucleaire)
    {
        $this->nucleaire = $nucleaire;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Parc\Nuclear
     */
    public function getNucleaire()
    {
        return $this->nucleaire;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Parc\Pv $pv
     */
    public function setPv($pv)
    {
        $this->pv = $pv;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Parc\Pv
     */
    public function getPv()
    {
        return $this->pv;
    }
}