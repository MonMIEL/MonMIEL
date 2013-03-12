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

    public function __construct($ParcNucleaire, $ParcEolien, $ParcPv, $ParcHydraulique,$ParcFlamme, $ParcAutres){

        $this->ParcNucleaire= $ParcNucleaire;
        $this->ParcEolien= $ParcEolien;
        $this->ParcPv= $ParcPv;
        $this->ParcHydraulique=$ParcHydraulique;
        $this->ParcFlamme= $ParcFlamme;
        $this->ParcAutres= $ParcAutres;
        echo 'Creation of final parc';
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
