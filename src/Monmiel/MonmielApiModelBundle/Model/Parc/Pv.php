<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;

use Monmiel\MonmielApiModelBundle\Model\Parc\Energy;

class Pv extends Energy
{
    //Represente la puissance unitaire d'une éolienne en MW
    const POWERUNIT=0.001;
    const LOADFACTOR=0.09;
    const AVAILABILITYRATE=1;

    function __construct($power = 0)
    {
        parent::__construct(self::AVAILABILITYRATE,
            self::LOADFACTOR,
            $power,
            self::POWERUNIT);
    }
}