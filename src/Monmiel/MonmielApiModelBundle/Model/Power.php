<?php
namespace Monmiel\MonmielApiModelBundle\Model;

use JMS\Serializer\Annotation as Ser;

/**
 * @Ser\AccessType("public_method")
 * @Ser\XmlRoot("power")
 */
class Power
{
    /**
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("nuclear")
     */
    protected $nuclear;

    /**
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("flame")
     */
    protected $flame;

    /**
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("wind")
     */
    protected $wind;

    /**
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("hydraulic")
     */
    protected $hydraulic;

    /**
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("photovoltaic")
     */
    protected $photovoltaic;

    /**
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("other")
     */
    protected $other;

    /**
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("import")
     */
    protected $import;

    /**
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("step")
     */
    protected $step;


    /**
     * @param $flame
     * @param $hydraulic
     * @param $import
     * @param $nuclear
     * @param $other
     * @param $photovoltaic
     * @param $step
     * @param $wind
     */
    function __construct($flame, $hydraulic, $import, $nuclear, $other, $photovoltaic, $step, $wind)
    {
        $this->flame = $flame;
        $this->hydraulic = $hydraulic;
        $this->import = $import;
        $this->nuclear = $nuclear;
        $this->other = $other;
        $this->photovoltaic = $photovoltaic;
        $this->step = $step;
        $this->wind = $wind;
    }

    public function toArray()
    {
        $total = $this->getTotal();
        $nucleaire = $this->nuclear/$total * 100;
        $photo = $this->photovoltaic/$total * 100;
        $eol = $this->wind/$total * 100;
        $hydrau= $this->hydraulic/$total * 100;
        $flamme = $this->flame/$total * 100;
        $step = $this->step/$total * 100;
        $import = $this->import/$total * 100;
        return Array(
            "nucleaire" => $nucleaire,
            "photovoltaique" => $photo,
            "eolien" => $eol,
            "hydraulique" => $hydrau,
            "flammes" => $flamme,
            "step" => $step,
            "import" => $import
        );
    }

    public function getTotal()
    {
        return $this->flame
            + $this->hydraulic
            + $this->import
            + $this->nuclear
            + $this->other
            + $this->photovoltaic
            + $this->step
            + $this->wind;
    }


    /**
     * @param float $flame
     */
    public function setFlame($flame)
    {
        $this->flame = $flame;
    }

    /**
     * @return float
     */
    public function getFlame()
    {
        return $this->flame;
    }

    /**
     * @param float $hydraulic
     */
    public function setHydraulic($hydraulic)
    {
        $this->hydraulic = $hydraulic;
    }

    /**
     * @return float
     */
    public function getHydraulic()
    {
        return $this->hydraulic;
    }

    /**
     * @param float $import
     */
    public function setImport($import)
    {
        $this->import = $import;
    }

    /**
     * @return float
     */
    public function getImport()
    {
        return $this->import;
    }

    /**
     * @param float $nuclear
     */
    public function setNuclear($nuclear)
    {
        $this->nuclear = $nuclear;
    }

    /**
     * @return float
     */
    public function getNuclear()
    {
        return $this->nuclear;
    }

    /**
     * @param float $other
     */
    public function setOther($other)
    {
        $this->other = $other;
    }

    /**
     * @return float
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * @param float $photovoltaic
     */
    public function setPhotovoltaic($photovoltaic)
    {
        $this->photovoltaic = $photovoltaic;
    }

    /**
     * @return float
     */
    public function getPhotovoltaic()
    {
        return $this->photovoltaic;
    }

    /**
     * @param float $step
     */
    public function setStep($step)
    {
        $this->step = $step;
    }

    /**
     * @return float
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param float $wind
     */
    public function setWind($wind)
    {
        $this->wind = $wind;
    }

    /**
     * @return float
     */
    public function getWind()
    {
        return $this->wind;
    }
}
