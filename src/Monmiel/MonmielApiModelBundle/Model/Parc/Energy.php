<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;

abstract class Energy
{
    /**
     * @var $power float
     */
    protected $power;

    /**
     * @var $loadFactor float
     */
    protected $loadFactor;

    /**
     * @var $availabilityRate float;
     */
    protected $availabilityRate;

    /**
     * @var $powerUnit float
     */
    protected $powerUnit;

    /**
     * @param $availabilityRate float
     * @param $loadFactor float
     * @param $power float
     */
    function __construct($availabilityRate, $loadFactor, $power, $powerUnit)
    {
        $this->setAvailabilityRate($availabilityRate);
        $this->setLoadFactor($loadFactor);
        $this->setPowerUnit($powerUnit);
        $this->setPower($power);
    }

    /**
     * @param float $availabilityRate
     */
    public function setAvailabilityRate($availabilityRate)
    {
        $this->availabilityRate = $availabilityRate;
    }

    /**
     * @return float
     */
    public function getAvailabilityRate()
    {
        return $this->availabilityRate;
    }

    /**
     * @param float $loadFactor
     */
    public function setLoadFactor($loadFactor)
    {
        $this->loadFactor = $loadFactor;
    }

    /**
     * @return float
     */
    public function getLoadFactor()
    {
        return $this->loadFactor;
    }

    /**
     * @param float $power
     */
    public function setPower($power)
    {
        $this->power = ($power / $this->getLoadFactor())*$this->getAvailabilityRate();
    }

    /**
     * @return float
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @return float
     */
    public function getParc()
    {
        return $this->getPower() / $this->getPowerUnit();
    }

    /**
     * @param  $powerUnit
     */
    public function setPowerUnit($powerUnit)
    {
        $this->powerUnit = $powerUnit;
    }

    /**
     * @return float
     */
    public function getPowerUnit()
    {
        return $this->powerUnit;
    }
}
