<?php

namespace Monmiel\MonmielApiModelBundle\Model\Response;

use Monmiel\MonmielApiModelBundle\Model\Day;
use JMS\Serializer\Annotation as Ser;

/**
 * @Ser\AccessType("public_method")
 * @Ser\XmlRoot("result")
 */
class SimulationResultSeries
{
    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Power $finalParcPower
     * @Ser\Type("Monmiel\MonmielApiModelBundle\Model\Power")
     * @Ser\SerializedName("finalParcPower")
     */
    protected $finalParcPower;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Power $targetParcPower
     * @Ser\Type("Monmiel\MonmielApiModelBundle\Model\Power")
     * @Ser\SerializedName("targetParcPower")
     */
    protected $targetParcPower;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Year
     * @Ser\Type("Monmiel\MonmielApiModelBundle\Model\Year")
     * @Ser\SerializedName("finalConso")
     */
    protected $finalConso;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Year
     * @Ser\Type("Monmiel\MonmielApiModelBundle\Model\Year")
     * @Ser\SerializedName("targetConso")
     */
    protected $targetConso;

    /**
     * @var $series array
     * @Ser\Type("array")
     * @Ser\SerializedName("series")
     *
     */
    protected $series;

    function __construct($days = array())
    {
        $this->days = $days;
        $this->series = array(
            "nucleaire" => array(),
            "photovoltaique" => array(),
            "eolien" => array(),
            "flamme" => array(),
            "hydraulique" => array(),
        );
    }

    /**
     * @param $day \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function addDay($day)
    {
        $this->updateSeries($day);
    }

    /**
     * @param array $days
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * @return array
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param $day Day
     */
    public function updateSeries($day)
    {
        $max = $day->getMax();
        $this->series["nucleaire"][] = $max['nucleaire'];
        $this->series["photovoltaique"][] = $max['photovoltaique'];
        $this->series["eolien"][] = $max['eolien'];
        $this->series["flamme"][] = $max['flamme'];
        $this->series["hydraulique"][] = $max['hydraulique'];
        $this->series["total"][] = array_sum($max);
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Power $finalParcPower
     */
    public function setFinalParcPower($finalParcPower)
    {
        $this->finalParcPower = $finalParcPower;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getFinalParcPower()
    {
        return $this->finalParcPower;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Power $targetParcPower
     */
    public function setTargetParcPower($targetParcPower)
    {
        $this->targetParcPower = $targetParcPower;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getTargetParcPower()
    {
        return $this->targetParcPower;
    }

    /**
     * @param array $series
     */
    public function setSeries($series)
    {
        $this->series = $series;
    }

    /**
     * @return array
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Year $finalConso
     */
    public function setFinalConso($finalConso)
    {
        $this->finalConso = $finalConso;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Year
     */
    public function getFinalConso()
    {
        return $this->finalConso;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Year $targetConso
     */
    public function setTargetConso($targetConso)
    {
        $this->targetConso = $targetConso;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Year
     */
    public function getTargetConso()
    {
        return $this->targetConso;
    }
}
