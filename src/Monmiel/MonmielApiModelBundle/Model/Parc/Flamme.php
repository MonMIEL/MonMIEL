<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:53
 * To change this template use File | Settings | File Templates.
 */
class Flamme
{
    private $max_Flamme;
    private $fc_Flamme;
    private $td_Flamme;
    private $power_Flamme;
    private $parc_Flamme;

    //Represente la puissance unitaire d'une éolienne en MW
    const PUISSANCEUNITAIRE=500;

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 1
    public function __construct(){
        $this->fc_Flamme=1;
        $this->td_Flamme=1;
        $this->max_Flamme=0;
        $this->power_Flamme=0;
    }

    public function setMaxFlamme($maxFlamme){
        if($maxFlamme> $this->max_Flamme){
            $this->max_Flamme=$maxFlamme;
        }
    }

    public function getMaxFlamme(){
        return $this->max_Flamme;
    }

    public function setFacteurChargeFlamme($fcFlamme){
        if(isset($fcFlamme)){
            $this->fc_Flamme=$fcFlamme;
        }

    }

    public function getFacteurChargeFlamme(){
        return $this->fc_Flamme;
    }

    public function setTauxDisponibiliteFlamme($tdFlamme){
        if(isset($tdFlamme)){
            $this->td_Flamme=$tdFlamme;
        }

    }

    public function getTauxDisponibiliteFlamme(){
        return $this->td_Flamme;
    }

    public function setPowerFlamme(){
        $this->power_Flamme=((($this->max_Flamme*4)/$this->td_Flamme)/$this->fc_Flamme);
    }

    public function getPowerFlamme(){
        if(isset($this->power_Flamme)){
            return $this->power_Flamme;
        }
        else{
            $this->setPowerFlamme();
            return $this->power_Flamme;
        }

    }

    public function getParcFlamme(){
        $this->parc_Flamme=( $this->puissance_Flamme/ self::PUISSANCEUNITAIRE );
        return $this->parc_Flamme;
    }
}
