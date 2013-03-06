<?php

namespace Monmiel\MonmielApiModelBundle\Model;

use JMS\Serializer\Annotation as Ser;

/**
 * @Ser\AccessType("public_method")
 * @Ser\XmlRoot("day")
 */
class Day
{
    /**
     * @var \DateTime
     * @Ser\Type("DateTime")
     * @Ser\SerializedName("date")
     */
    protected $dateTime;

    /**
     * @var array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     * @Ser\Type("array<Monmiel\MonmielApiModelBundle\Model\Quarter>")
     * @Ser\SerializedName("quarters")
     */
    protected $quarters;

    function __construct($dateTime, $quarters = array())
    {
        $this->dateTime = $dateTime;
        $this->quarters = $quarters;
    }

    public function getKey()
    {
        $format = "Y-m-d";
        return date_format($this->dateTime, $format);
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
