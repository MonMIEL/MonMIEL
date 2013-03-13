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
    /**
     * @var $max_Flamme Float
     * @var $fc_Flamme Float
     * @var $td_Flamme Float
     * @var $power_Flamme Float
     * @var $parc_Flamme Float
     */
    private $max_Flamme;
    private $fc_Flamme;
    private $td_Flamme;
    private $power_Flamme;
    private $parc_Flamme;

    //Represente la puissance unitaire d'une éolienne en MW
    const POWERUNIT=500;
    const LOADFACTOR=1;
    const AVAILABILITYRATE=0.95;

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 1
    public function __construct($loadFactor= self::LOADFACTOR, $availabilityRate= self::AVAILABILITYRATE ,$power=0){
        $this->fc_Flamme=$loadFactor;
        $this->td_Flamme=$availabilityRate;
        $this->max_Flamme=0;
        $this->power_Flamme=$power;
    }

    public function setMaxFlamme($maxFlamme){
        if($maxFlamme> $this->max_Flamme){
            $this->max_Flamme=$maxFlamme;
        }
    }

    public function getMaxFlamme(){
        return $this->max_Flamme;
    }

    public function setPowerFlamme(){
        $this->power_Flamme=(($this->max_Flamme));
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
        $this->parc_Flamme=( $this->power_Flamme/ self::POWERUNIT );
        return $this->parc_Flamme;
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
}
