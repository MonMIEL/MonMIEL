<?php
/**
 * Created by JetBrains PhpStorm.
 * User: qiaob
 * Date: 07/03/13
 * Time: 15:48
 * To change this template use File | Settings | File Templates.
 */
class AskUser
{
    /**
     * @var float
     * @Ser\Type("float")
     */
    protected $nuclear;

    /**
     * @var float
     * @Ser\Type("float")
     */
    protected $flame;



    /**
     * @var float
     * @Ser\Type("float")
     */
    protected $wind;

    /**
     * @var float
     * @Ser\Type("float")
     */
    protected $hydraulic;

    /**
     * @var float
     * @Ser\Type("float")
     */
    protected $photovoltaic;

    /**
     * @var float
     * @Ser\Type("float")
     */
    protected $other;

    /**
     * @var float
     * @Ser\Type("float")
     */
    protected $import;

    /**
     * @var float
     * @Ser\Type("float")
     */
    protected $step;


    /**
     * @var float
     * @Ser\Type("float")
     */
    protected $total;


    /**
     * @param $flame
     * @param $hydraulic
     * @param $import
     * @param $nuclear
     * @param $other
     * @param $photovoltaic
     * @param $step
     * @param $total
     * @param $wind
     */
    function __construct($flame, $hydraulic, $import, $nuclear, $other, $photovoltaic, $step, $total, $wind)
    {
        $this->flame = $flame;
        $this->hydraulic = $hydraulic;
        $this->import = $import;
        $this->nuclear = $nuclear;
        $this->other = $other;
        $this->photovoltaic = $photovoltaic;
        $this->step = $step;
        $this->total = $total;
        $this->wind = $wind;
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
     * @param float $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
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
