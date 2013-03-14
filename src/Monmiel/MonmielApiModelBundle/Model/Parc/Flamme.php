<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;

use Monmiel\MonmielApiModelBundle\Model\Parc\Energy;

class Flamme extends Energy
{
    //Represente la puissance unitaire d'une éolienne en MW
    const POWERUNIT=500;
    const LOADFACTOR=1;
    const AVAILABILITYRATE=0.95;

    /**
     * @var $maxFlamme float
     */
    protected $maxFlamme;

    function __construct($power = 0)
    {
        parent::__construct(self::AVAILABILITYRATE,
            self::LOADFACTOR,
            $power,
            self::POWERUNIT);
        $this->maxFlamme = 0;
    }

    /**
     * @param float $maxFlamme
     */
    public function setMaxFlamme($maxFlamme)
    {
        if ($maxFlamme > $this->getMaxFlamme()) {
            $this->maxFlamme = $maxFlamme;
        }
    }

    /**
     * @return float
     */
    public function getMaxFlamme()
    {
        return $this->maxFlamme;
    }
}