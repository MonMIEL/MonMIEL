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

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 0.762 (année 2011)
    public function __construct($loadFactor=0.762, $availabilityRate=0.807,$power=0){
        $this->fc_nuclear=$loadFactor;
        $this->td_nuclear=$availabilityRate;
        $this->power_Nuclear=$power;
    }

    public function setPowerNuclear($PowerNuclear,$percentOfMix){
        if(isset($PowerNuclear)&& isset($percentOfMix)){
            $this->setFacteurChargeNuclear($percentOfMix);

            $this->power_Nuclear=$PowerNuclear/$this->fc_nuclear;
        }
    }

    //Retourne la valeur finale après prise en compte du facteur de charge et du taux de disponibilité
    // (Valeur Max * 4 / tx de dispo) / facteur de charge
    public function getPowerNuclear(){
        return $this->power_Nuclear;
    }

    protected function setFacteurChargeNuclear($percentOfNuclear){
        if(isset($percentOfNuclear)){
            $upper_percent=0.75;
            $upper_value=0.76;
            $lower_percent=0.25;
            $lower_value=0.95;
            if(isset($percentOfNuclear)){
                if($percentOfNuclear>= $upper_percent){
                    $this->fc_nuclear=$upper_value;
                }
                elseif(($upper_percent >$percentOfNuclear) && ($percentOfNuclear > $lower_percent)){
                    //ex:
                    /**
                     * @var $facteur Float
                     */
                    $facteur=(($lower_value-$upper_value)*100)/(($upper_percent-$lower_percent)*100);

                    $this->fc_nuclear= ($upper_percent-$percentOfNuclear)*$facteur + $upper_value;

                }
                elseif($percentOfNuclear <= $lower_percent){
                    $this->fc_nuclear=$lower_value;
                }
            }
        }
    }

    public function getFacteurChargeNuclear(){
        return $this->fc_nuclear;
    }

    private function setTauxDisponibiliteNuclear($percentOfNuclear){

    }

    public function getTauxDisponibiliteNuclear(){
        return $this->td_nuclear;
    }


    public function getParcNuclear(){
        $this->parc_Nuclear=( ($this->power_Nuclear/$this->td_nuclear)/ self::PUISSANCEUNITAIRE );
        return $this->parc_Nuclear;
    }

}

