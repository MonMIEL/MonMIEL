<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:48
 * To change this template use File | Settings | File Templates.
 */
class Nucleaire
{
    private $max_nucleaire;
    private $fc_nucleaire;
    private $td_nucleaire;
    private $puissance_Nucleaire;
    private $parc_Nucleaire;
    
    //Represente la puissance unitaire d'un réacteur en MW
    const PUISSANCEUNITAIRE=1090;

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 1
    public function __construct(){
        $this->fc_nucleaire=1;
        $this->td_nucleaire=1;
        $this->max_nucleaire=0;
    }

    public function setMaxNucleaire($maxNuc){
        if($maxNuc> $this->max_nucleaire){
            $this->max_nucleaire=$maxNuc;
        }
    }

    public function getMaxNucleaire(){
        return $this->max_nucleaire;
    }

    public function setFacteurChargeNucleaire($fcNucleaire){
        if(isset($fcNucleaire)){
            $this->fc_nucleaire=$fcNucleaire;
        }
    }

    public function getFacteurChargeNucleaire(){
        return $this->fc_nucleaire;
    }

    public function setTauxDisponibiliteNucleaire($mix){
        if(isset($mix)){
            $this->td_nucleaire=$mix;
        }
    }

    public function getTauxDisponibiliteNucleaire(){
        return $this->td_nucleaire;
    }

    //Retourne la valeur finale après prise en compte du facteur de charge et du taux de disponibilité
    // (Valeur Max * 4 / tx de dispo) / facteur de charge

    public function getValueNucleaire(){
        $this->puissance_Nucleaire=((($this->getMaxNucleaire()*4)/$this->getTauxDisponibiliteNucleaire())/$this->getFacteurChargeNucleaire());
        return $this->puissance_Nucleaire;
    }

    public function getParcNucleaire(){
        $this->parc_Nucleaire=( $this->puissance_Nucleaire/ self::PUISSANCEUNITAIRE );
        return $this->parc_Nucleaire;
    }

}

