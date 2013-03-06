<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:52
 * To change this template use File | Settings | File Templates.
 */
class Pv
{
    private $max_pv;
    private $fc_pv;
    private $td_pv;

    //Represente la puissance unitaire d'un panneau photovoltaique par M² en MW
    const PUISSANCEUNITAIRE=0.001;

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 1
    public function __construct(){
        $this->fc_pv=1;
        $this->td_pv=1;
        $this->max_pv=0;
    }

    public function setMaxPv($maxPv){
        if($maxPv> $this->max_pv){
            $this->max_pv=$maxPv;
        }
    }

    public function getMaxPv(){
        return $this->max_pv;
    }

    public function setFacteurChargePv($fcPv){
        if(isset($fcPv)){
            $this->fc_pv=$fcPv;
        }
    }

    public function getFacteurChargePv(){
        return $this->fc_pv;
    }

    public function setTauxDisponibilitePv($tdPv){
        if(isset($tdPv)){
            $this->td_pv=$tdPv;
        }
    }

    public function getTauxDisponibilitePv(){
        return $this->td_pv;
    }

    public function getValuePv(){
        return (($this->getMaxPv()/$this->getTauxDisponibilitePv())/$this->getFacteurChargePv());
    }
}
