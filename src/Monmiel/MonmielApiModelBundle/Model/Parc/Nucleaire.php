<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:48
 * To change this template use File | Settings | File Templates.
 */
class Nuclear
{
    private $fc_nuclear;
    private $td_nuclear;
    private $power_Nuclear;
    private $parc_Nuclear;
    
    //Represente la puissance unitaire d'un réacteur en MW
    const PUISSANCEUNITAIRE=1090;

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 1
    public function __construct(){
        $this->fc_nuclear=1;
        $this->td_nuclear=1;
        $this->power_Nuclear=0;
    }

    public function setPowerNuclear($PowerNuclear){
        if(isset($PowerNuclear)){
            $this->power_Nuclear=((($PowerNuclear*4)/$this->td_nuclear)/$this->fc_nuclear);
        }
    }

    //Retourne la valeur finale après prise en compte du facteur de charge et du taux de disponibilité
    // (Valeur Max * 4 / tx de dispo) / facteur de charge
    public function getPowerNuclear(){
        return $this->power_Nuclear;
    }

    public function setFacteurChargeNuclear($fcnuclear){
        if(isset($fcnuclear)){
            $this->fc_nuclear=$fcnuclear;
        }
    }

    public function getFacteurChargeNuclear(){
        return $this->fc_nuclear;
    }

    public function setTauxDisponibiliteNuclear($percentOfNuclear){
        $upper_percent=0.75;
        $upper_value=0.76;
        $lower_percent=0.25;
        $lower_value=0.95;
        if(isset($percentOfNuclear)){
            if($percentOfNuclear>= $upper_percent){
                $this->td_nuclear=$upper_value;
            }
            elseif(($upper_percent >$percentOfNuclear) && ($percentOfNuclear > $lower_percent)){
                //ex:

                $facteur=(($upper_percent-$lower_percent)*100)/(($lower_value-$upper_percent)*100);
                $this->td_nuclear= ($upper_percent-$percentOfNuclear)*$facteur + $upper_value;

            }
            elseif($percentOfNuclear <= $lower_percent){
                $this->td_nuclear=$lower_value;
            }
        }
    }

    public function getTauxDisponibiliteNuclear(){
        return $this->td_nuclear;
    }


    public function getParcNuclear(){
        $this->parc_Nuclear=( $this->power_Nuclear/ self::PUISSANCEUNITAIRE );
        return $this->parc_Nuclear;
    }

}

