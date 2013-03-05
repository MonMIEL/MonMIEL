<?php

namespace Monmiel\MonmielApiModelBundle\Model;


class Jour_DAO
{

    /**
     * @var \DateTime
     */
    protected $dateTime;

    /**
     * @var array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     */
    protected $quarters;

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
