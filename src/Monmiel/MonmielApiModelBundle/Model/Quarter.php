<?php

namespace Monmiel\MonmielApiModelBundle\Model;

use JMS\Serializer\Annotation as Ser;

/**
 * @Ser\AccessType("public_method")
 * @Ser\XmlRoot("quarter")
 */
class Quarter
{
    /**
     * @var \DateTime
     * @Ser\Type("DateTime<'Y-m-d H:i:s', 'Europe/Paris'>")
     */
    protected $date;

    /**
     * @var integer
     * @Ser\Type("integer")
     */
    protected $flamme;

    /**
     * @var integer
     * @Ser\Type("integer")
     */
    protected $nucleaire;

    /**
     * @var integer
     * @Ser\Type("integer")
     */
    protected $eolien;

    /**
     * @var integer
     * @Ser\Type("integer")
     */
    protected $hydraulique;

    /**
     * @var integer
     * @Ser\Type("integer")
     */
    protected $photovoltaique;

    /**
     * @var integer
     * @Ser\Type("integer")
     */
    protected $autre;

    /**
     * @var integer
     * @Ser\Type("integer")
     */
    protected $consoTotal;

    /**
     * @var integer
     * @Ser\Type("integer")
     */
    protected $interval=15;//default

    function __construct($date, $consoTotal = 0, $eolien = 0, $flamme = 0, $hydraulique = 0, $nucleaire = 0, $photovoltaique = 0, $autre = 0, $interval = 0)
    {
        $this->autre = $autre;
        $this->consoTotal = $consoTotal;
        $this->date = $date;
        $this->eolien = $eolien;
        $this->flamme = $flamme;
        $this->hydraulique = $hydraulique;
        $this->nucleaire = $nucleaire;
        $this->photovoltaique = $photovoltaique;
        $this->interval = $interval;
    }

    /**
     * @param int $autre
     */
    public function setAutre($autre)
    {
        $this->autre = $autre;
    }

    /**
     * @return int
     */
    public function getAutre()
    {
        return $this->autre;
    }

    /**
     * @param int $consoTotal
     */
    public function setConsoTotal($consoTotal)
    {
        $this->consoTotal = $consoTotal;
    }

    /**
     * @return int
     */
    public function getConsoTotal()
    {
        return $this->consoTotal;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param int $eolien
     */
    public function setEolien($eolien)
    {
        $this->eolien = $eolien;
    }

    /**
     * @return float
     */
    public function getEolien()
    {
        return $this->eolien;
    }

    /**
     * @param float $flamme
     */
    public function setFlamme($flamme)
    {
        $this->flamme = $flamme;
    }

    /**
     * @return float
     */
    public function getFlamme()
    {
        return $this->flamme;
    }

    /**
     * @param int $hydraulique
     */
    public function setHydraulique($hydraulique)
    {
        $this->hydraulique = $hydraulique;
    }

    /**
     * @return int
     */
    public function getHydraulique()
    {
        return $this->hydraulique;
    }

    /**
     * @param int $nucleaire
     */
    public function setNucleaire($nucleaire)
    {
        $this->nucleaire = $nucleaire;
    }

    /**
     * @return int
     */
    public function getNucleaire()
    {
        return $this->nucleaire;
    }

    /**
     * @param int $photovoltaique
     */
    public function setPhotovoltaique($photovoltaique)
    {
        $this->photovoltaique = $photovoltaique;
    }

    /**
     * @return int
     */
    public function getPhotovoltaique()
    {
        return $this->photovoltaique;
    }

    /**
     * @param integer $interval
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;
    }

    /**
     * @return integer
     */
    public function getInterval()
    {
        if ($this->interval==0)
            return 15;

        return $this->interval;
    }


    /**
     * steps used
     * @var float
     * @Ser\Exclude
     */
    protected $steps=0;

    /**
     * value imported
     * @var float
     * @Ser\Exclude
     */
    protected $import=0;
    /**
     * value exported
     * @var float
     * @Ser\Exclude
     */
    protected $export=0;

    /**
     * @param float $export
     */
    public function setExport($export)
    {
        $this->export = $export;
    }

    /**
     * @return float
     */
    public function getExport()
    {
        return $this->export;
    }

    /**
     * @param float $steps
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;
    }

    /**
     * @return float
     */
    public function getSteps()
    {
        return $this->steps;
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



}