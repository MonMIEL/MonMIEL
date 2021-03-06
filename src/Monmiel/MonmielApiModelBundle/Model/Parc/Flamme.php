<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;

use Monmiel\MonmielApiModelBundle\Model\Parc\Energy;

class Flamme extends Energy
{
    //Represente la puissance unitaire d'une éolienne en MW
    const POWERUNIT=500;
    const LOADFACTOR=1;
    const AVAILABILITYRATE=0.95;

    function __construct($power = 0)
    {
        parent::__construct(self::AVAILABILITYRATE,
            self::LOADFACTOR,
            $power,
            self::POWERUNIT);
        $this->power = 0;
    }

    /**
     * @param float $power
     */
    public function setPower($power)
    {
        if ($power > $this->getPower()) {
            $this->power = $power;
        }
    }
}