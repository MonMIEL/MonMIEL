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
     * @Ser\Type("DateTime<'Y-m-d H:i:s', 'Europe/Paris'>")
     * @Ser\SerializedName("date")
     */
    protected $dateTime;

    /**
     * @var array<\Monmiel\MonmielApiModelBundle\Model\Quarter>
     * @Ser\Type("array<Monmiel\MonmielApiModelBundle\Model\Quarter>")
     * @Ser\SerializedName("quarters")
     */
    protected $quarters;

    function __construct($dateTime = null, $quarters = array())
    {
        $this->dateTime = $dateTime;
        $this->quarters = $quarters;
    }

    public function getKey()
    {
        $format = "Y-m-d";
        return date_format($this->dateTime, $format);
    }

    public function getMax()
    {
        $max = array("nucleaire" => 0, "photovoltaique" => 0, "eolien" => 0, "flamme" => 0, "hydraulique" => 0, "import" => 0, "steps" => 0);
        /** @var $quarter Quarter */
        foreach ($this->quarters as $quarter) {
            if ($max["nucleaire"] < $quarter->getNucleaire()) { $max["nucleaire"] = $quarter->getNucleaire(); }
            if ($max["photovoltaique"] < $quarter->getPhotovoltaique()) { $max["photovoltaique"] = $quarter->getPhotovoltaique(); }
            if ($max["eolien"] < $quarter->getEolien()) { $max["eolien"] = $quarter->getEolien(); }
            if ($max["flamme"] < $quarter->getFlamme()) { $max["flamme"] = $quarter->getFlamme(); }
            if ($max["hydraulique"] < $quarter->getHydraulique()) { $max["hydraulique"] = $quarter->getHydraulique(); }
            if ($max["import"] < $quarter->getImport()) { $max["import"] = $quarter->getImport(); }
            if ($max["steps"] < $quarter->getSteps()) { $max["steps"] = $quarter->getSteps(); }
        }

        return $max;
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
     * @param array<Quarter> $quarters
     */
    public function setQuarters($quarters)
    {
        $this->quarters = $quarters;
    }

    /**
     * @return array<Quarter>
     */
    public function getQuarters()
    {
        return $this->quarters;
    }
}
