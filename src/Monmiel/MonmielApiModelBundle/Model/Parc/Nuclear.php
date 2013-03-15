<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;

use Monmiel\MonmielApiModelBundle\Model\Parc\Energy;

class Nuclear extends Energy
{
    //Represente la puissance unitaire d'un réacteur nucleaire en MW
    const POWERUNIT=1090;

    function __construct($power, $nukePercent)
    {
        $this->setAvailabilityRate($nukePercent);
        $this->setLoadFactor($nukePercent);
        $this->setPowerUnit(self::POWERUNIT);
        $this->setPowerNuc($power,$nukePercent);
    }

    public function setLoadFactor($percentOfNuclear){

        $upper_percent=0.75;
        $upper_value=0.76;
        $lower_percent=0.25;
        $lower_value=0.95;

        if ($percentOfNuclear >= $upper_percent){
            $this->loadFactor=$upper_value;
        } elseif (($upper_percent >$percentOfNuclear) && ($percentOfNuclear > $lower_percent)) {
            $facteur=(($lower_value-$upper_value)*100)/(($upper_percent-$lower_percent)*100);
            $this->loadFactor= ($upper_percent-$percentOfNuclear)*$facteur + $upper_value;
        } elseif ($percentOfNuclear <= $lower_percent) {
            $this->loadFactor=$lower_value;
        }
    }

    public function setAvailabilityRate($percentOfNuclear)
    {
        $upper_percent=0.75;
        $upper_value=0.81;
        $lower_percent=0.25;
        $lower_value=0.95;

        if ($percentOfNuclear >= $upper_percent){
            $this->availabilityRate=$upper_value;
        } elseif (($upper_percent >$percentOfNuclear) && ($percentOfNuclear > $lower_percent)) {
            $facteur=(($lower_value-$upper_value)*100)/(($upper_percent-$lower_percent)*100);
            $this->availabilityRate= ($upper_percent-$percentOfNuclear)*$facteur + $upper_value;
        } elseif ($percentOfNuclear <= $lower_percent) {
            $this->availabilityRate=$lower_value;
        }
    }

    public function setPowerNuc($power,$percentNuclear)
    {
        $this->power = ($power / $this->getLoadFactor($percentNuclear))*$this->getAvailabilityRate($percentNuclear);
    }

}