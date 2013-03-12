<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 05/03/13
 * Time: 17:49
 * To change this template use File | Settings | File Templates.
 */
class ParcFinal
{
    private $ParcNucleaire;
    private $ParcEolien;
    private $ParcPv;
    private $ParcHydraulique;
    private $ParcFlamme;
    private $ParcAutres;

    private $PuisNucleaire;
    private $PuisEolien;
    private $PuisPv;
    private $PuisHydraulique;
    private $PuisFlamme;
    private $PuisAutres;

    public function __construct($PuisNucleaire, $PuisEolien, $PuisPv, $PuisHydraulique, $PuisFlamme, $PuisAutres, $ParcNucleaire, $ParcEolien, $ParcPv, $ParcHydraulique,$ParcFlamme, $ParcAutres){
        $this->PuisNucleaire= $PuisNucleaire;
        $this->PuisEolien= $PuisEolien;
        $this->PuisPv= $PuisPv;
        $this->PuisHydraulique=$PuisHydraulique;
        $this->PuisFlamme= $PuisFlamme;
        $this->PuisAutres= $PuisAutres;

        $this->ParcNucleaire= $ParcNucleaire;
        $this->ParcEolien= $ParcEolien;
        $this->ParcPv= $ParcPv;
        $this->ParcHydraulique=$ParcHydraulique;
        $this->ParcFlamme= $ParcFlamme;
        $this->ParcAutres= $ParcAutres;
    }

    public function getPuisNucleaire(){
        return $this->PuisNucleaire;
    }

    public function getPuisEolien(){
        return $this->PuisEolien;
    }

    public function getPuisPv(){
        return $this->PuisPv;
    }

    public function getPuisHydraulique(){
        return $this->PuisHydraulique;
    }

    public function getPuisFlamme(){
        return $this->PuisFlamme;
    }

    public function getPuisAutre(){
        return $this->PuisAutres;
    }

    public function getParcNucleaire(){
        return $this->ParcNucleaire;
    }

    public function getParcEolien(){
        return $this->ParcEolien;
    }

    public function getParcPv(){
        return $this->ParcPv;
    }

    public function getParcHydraulique(){
        return $this->ParcHydraulique;
    }

    public function getParcFlamme(){
        return $this->ParcFlamme;
    }

    public function getParcAutre(){
        return $this->ParcAutres;
    }
}
