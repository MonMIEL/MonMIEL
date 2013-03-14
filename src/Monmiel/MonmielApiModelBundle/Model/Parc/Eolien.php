<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;

use Monmiel\MonmielApiModelBundle\Model\Parc\Energy;

class Eolien extends Energy
{
    //Represente la puissance unitaire d'une éolienne en MW
    const POWERUNIT=1.5;
    const LOADFACTOR=0.22;
    const AVAILABILITYRATE=0.98;

    function __construct($power = 0)
    {
        parent::__construct(self::AVAILABILITYRATE,
                            self::LOADFACTOR,
                            $power,
                            self::POWERUNIT);
    }
}
