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

    public function setMaxPv($maxPv){
        if($maxPv> $this->max_pv){
            $this->max_pv=$maxPv;
        }
    }

    public function getMaxPv(){
        return $this->max_pv;
    }

    public function setFacteurChargePv($fcPv){
        $this->fc_pv=$fcPv;
    }

    public function getFacteurChargePv(){
        return $this->fc_pv;
    }

    public function setTauxDisponibilitePv($tdPv){
        $this->td_pv=$tdPv;
    }

    public function getTauxDisponibilitePv(){
        return $this->td_pv;
    }
}
