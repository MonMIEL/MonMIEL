<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;

use Monmiel\MonmielApiModelBundle\Model\Parc\Energy;

class Nuclear extends Energy
{
    //Represente la puissance unitaire d'une éolienne en MW
    const POWERUNIT=1090;
    const LOADFACTOR=0.762;
    const AVAILABILITYRATE=0.807;

    function __construct($power = 0, $nukePercent = 1)
    {
        parent::__construct(self::AVAILABILITYRATE,
            self::LOADFACTOR,
            $power,
            self::POWERUNIT);
    }

//    public function setLoadFactor($percentOfNuclear = 1){
//
//        $upper_percent=0.75;
//        $upper_value=0.76;
//        $lower_percent=0.25;
//        $lower_value=0.95;
//
//        if ($percentOfNuclear >= $upper_percent){
//            $this->loadFactor=$upper_value;
//        } elseif (($upper_percent >$percentOfNuclear) && ($percentOfNuclear > $lower_percent)) {
//            $facteur=(($lower_value-$upper_value)*100)/(($upper_percent-$lower_percent)*100);
//            $this->loadFactor= ($upper_percent-$percentOfNuclear)*$facteur + $upper_value;
//        } elseif ($percentOfNuclear <= $lower_percent) {
//            $this->loadFactor=$lower_value;
//        }
//    }
}