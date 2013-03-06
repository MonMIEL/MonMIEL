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
use Monmiel\MonmielApiModelBundle\Model\Parc\Flamme;
use Monmiel\MonmielApiModelBundle\Model\Parc\ParcFinal;



class Parc{

    private static $instance =null;

    private $nucleaire;
    private $eolien;
    private $pv;
    private $hydraulique;
    private $flamme;
    private $autres;

    private function __construct(){
        $this->nucleaire= new Nucleaire();
        $this->eolien= new Eolien();
        $this->pv=new Pv();
        $this->hydraulique=new Hydraulique();
        $this->flamme=new Flamme();
        $this->autres=new Autres();

    }


    //Pattern singleton, pour ne créer qu'une seule fois le parc afin de ne pas remettre à zéro les attributs chaque jour
    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new Parc();
            echo 'Création du parc initial';
        }
        return self::$instance;
    }

    //Méthode permettant de vérifier si les valeurs en paramètre sont les max
    public function setMaxValue($valeurNucleaire, $valeurEolien, $valeurPv, $valeurHydraulique, $valeurFlamme, $valeurAutre){
        $this->nucleaire->setMaxNucleaire($valeurNucleaire);
        $this->eolien->setMaxEolien($valeurEolien);
        $this->pv->setMaxPv($valeurPv);
        $this->hydraulique->setMaxHydraulique($valeurHydraulique);
        $this->flamme->setMaxFlamme($valeurFlamme);
        $this->autres->setMaxAutre($valeurAutre);
    }


    //Met a jour le facteur de charge et le taux de disponibilité pour le nucléaire, l'éolien, le pv et l'hydraulique en fonction du mix final
    protected function DefineRate($mixFinal){
        $this->nucleaire->setFacteurChargeNucleaire($mixFinal);
        $this->eolien->setFacteurChargeEolien($mixFinal);
        $this->pv->setFacteurChargePv($mixFinal);
        $this->hydraulique->setFacteurChargeHydraulique($mixFinal);
        $this->flamme->setFacteurChargeFlamme($mixFinal);

        $this->nucleaire->setTauxDisponibiliteNucleaire($mixFinal);
        $this->eolien->setTauxDisponibiliteEolien($mixFinal);
        $this->pv->setTauxDisponibilitePv($mixFinal);
        $this->hydraulique->setTauxDisponibiliteHydraulique($mixFinal);
        $this->flamme->setTauxDisponibiliteFlamme($mixFinal);
    }

    //Retourne le parc final (pour le moment que l'énergie, pas de réacteur par exemple
    public function getParc($mixFinal){
        //On défini le taux de disponibilité et le facteur de charge pour chacune des energies
        $this->DefineRate($mixFinal);

        //On recupere l'energie nécessaire pour chaque énergie
        $PuisNuc=$this->nucleaire->getValueNucleaire();
        $PuisEol=$this->eolien->getValueEolien();
        $PuisHyd=$this->hydraulique->getValueHydraulique();
        $PuisPv=$this->pv->getValuePv();
        $PuisFlamme=$this->flamme->getValueFlamme();
        $PuisAut=$this->autres->getValueAutre();

        //On recupere l'energie nécessaire pour chaque énergie
        $ParcNuc=$this->nucleaire->getParcNucleaire();
        $ParcEol=$this->eolien->getParcEolien();
        $ParcHyd=$this->hydraulique->getParcHydraulique();
        $ParcPv=$this->pv->getParcPv();
        $ParcFlamme=$this->flamme->getParcFlamme();
        $ParcAut=$this->autres->getParcAutre();

        //Creation d'un object ParcFinal pour ne retourner que ce qui est necessaire
        $newParc=new ParcFinal($PuisNuc,$PuisEol,$PuisHyd,$PuisPv,$PuisFlamme,$PuisAut,$ParcNuc,$ParcEol,$ParcHyd,$ParcPv,$ParcFlamme,$ParcAut);
        return $newParc;
    }




}


