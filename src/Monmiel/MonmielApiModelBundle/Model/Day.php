<?php

namespace Monmiel\MonmielApiModelBundle\Model;


class Day
{

    /**
     * @var \DateTime
     */
    protected $dateTime;

    /**
     * @var array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     */
    protected $quarters;

    function __construct($dateTime, $quarters = array())
    {
        $this->dateTime = $dateTime;
        $this->quarters = $quarters;
    }

    /**
     * @param $quarter Quarter
     */
    public function addQuarters($quarter) {
        $this->quarters[] = $quarter;
    }

    /**
     * @param $quaterNb integer Le quarter à récupérer de 0 à 39
     */
    public function getQuarter($quarterNb)
    {
        return $this->quarters[$quarterNb];
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param array $quarters
     */
    public function setQuarters($quarters)
    {
        $this->quarters = $quarters;
    }

    /**
     * @return array
     */
    public function getQuarters()
    {
        return $this->quarters;
    }








}
