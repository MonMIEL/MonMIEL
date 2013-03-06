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
use Monmiel\MonmielApiModelBundle\Model\Parc\ParcFinal;



class Parc{

    private static $instance =null;

    private $nucleaire;
    private $eolien;
    private $pv;
    private $hydraulique;
    private $autres;

    private function __construct(){
        $this->nucleaire= new Nucleaire();
        $this->eolien= new Eolien();
        $this->pv=new Pv();
        $this->hydraulique=new Hydraulique();
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
    public function setMaxValue($valeurNucleaire, $valeurEolien, $valeurPv, $valeurHydraulique, $valeurAutre){
        $this->nucleaire->setMaxNucleaire($valeurNucleaire);
        $this->eolien->setMaxEolien($valeurEolien);
        $this->pv->setMaxPv($valeurPv);
        $this->hydraulique->setMaxHydraulique($valeurHydraulique);
        $this->autres->setMaxAutre($valeurAutre);
    }


    //Met a jour le facteur de charge et le taux de disponibilité pour le nucléaire, l'éolien, le pv et l'hydraulique en fonction du mix final
    protected function DefineRate($mixFinal){
        $this->nucleaire->setFacteurChargeNucleaire($mixFinal);
        $this->eolien->setFacteurChargeEolien($mixFinal);
        $this->pv->setFacteurChargePv($mixFinal);
        $this->hydraulique->setFacteurChargeHydraulique($mixFinal);

        $this->nucleaire->setTauxDisponibiliteNucleaire($mixFinal);
        $this->eolien->setTauxDisponibiliteEolien($mixFinal);
        $this->pv->setTauxDisponibilitePv($mixFinal);
        $this->hydraulique->setTauxDisponibiliteHydraulique($mixFinal);
    }

    //Retourne le parc final (pour le moment que l'énergie, pas de réacteur par exemple
    public function getParc($mixFinal){
        //On défini le taux de disponibilité et le facteur de charge pour chacune des energies
        $this->DefineRate($mixFinal);

        //On recupere l'energie nécessaire pour chaque énergie
        $nuc=$this->nucleaire->getValueNucleaire();
        $eol=$this->eolien->getValueEolien();
        $hyd=$this->hydraulique->getValueHydraulique();
        $pv=$this->pv->getValuePv();
        $aut=$this->autres->getValueAutre();

        //Creation d'un object ParcFinal pour ne retourner que ce qui est necessaire
        $newParc=new ParcFinal($nuc,$eol,$hyd,$pv,$aut);
        return $newParc;
    }




}


