<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:05
 * To change this template use File | Settings | File Templates.
 */
use Monmiel\MonmielApiModelBundle\Model\Parc\Nucleaire;
use Monmiel\MonmielApiModelBundle\Model\Parc\Eolien;
use Monmiel\MonmielApiModelBundle\Model\Parc\Hydraulique;
use Monmiel\MonmielApiModelBundle\Model\Parc\Pv;
use Monmiel\MonmielApiModelBundle\Model\Parc\Autres;



class Parc{

    private $nucleaire;
    private $eolien;
    private $pv;
    private $hydraulique;
    private $autres;

    public function __construct(){
        $this->nucleaire= new Nucleaire();
        $this->eolien= new Eolien();
        $this->pv=new Pv();
        $this->hydraulique=new Hydraulique();
        $this->autres=new Autres();

    }

    //Méthode permettant de vérifier si les valeurs en paramètre sont les max
    public function setMaxValue($valeurNucleaire, $valeurEolien, $valeurPv, $valeurHydraulique, $valeurAutre){
        $this->nucleaire->setMaxNucleaire($valeurNucleaire);
        $this->eolien->setMaxEolien($valeurEolien);
        $this->pv->setMaxPv($valeurPv);
        $this->hydraulique->setMaxHydraulique($valeurHydraulique);
        $this->autres->setMaxAutre($valeurAutre);
    }


    //Met a jour le facteur de charge et le taux de disponibilité pour le nucléaire, l'éolien, le pv et l'hydrolique en fonction du mix final
    public function DefineRate($mixFinal){
        $this->nucleaire->setFacteurChargeNucleaire($mixFinal);
        $this->eolien->setFacteurChargeEolien($mixFinal);
        $this->pv->setFacteurChargePv($mixFinal);
        $this->hydraulique->setFacteurChargeHydraulique($mixFinal);

        $this->nucleaire->setTauxDisponibiliteNucleaire($mixFinal);
        $this->eolien->setTauxDisponibiliteEolien($mixFinal);
        $this->pv->setTauxDisponibilitePv($mixFinal);
        $this->hydraulique->setTauxDisponibiliteHydraulique($mixFinal);
    }




}


