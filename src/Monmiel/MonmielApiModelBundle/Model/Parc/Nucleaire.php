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

    public function setMaxNucleaire($maxNuc){
        if($maxNuc> $this->max_nucleaire){
            $this->max_nucleaire=$maxNuc;
        }
    }

    public function getMaxNucleaire(){
        return $this->max_nucleaire;
    }

    public function setFacteurChargeNucleaire($fcNucleaire){
        $this->fc_nucleaire=$fcNucleaire;
    }

    public function getFacteurChargeNucleaire(){
        return $this->fc_nucleaire;
    }

    public function setTauxDisponibiliteNucleaire($tdNucleaire){
        $this->td_nucleaire=$tdNucleaire;
    }

    public function getTauxDisponibiliteNucleaire(){
        return $this->td_nucleaire;
    }
}

