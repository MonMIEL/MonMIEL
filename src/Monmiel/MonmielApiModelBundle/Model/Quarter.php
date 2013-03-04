<?php

namespace Monmiel\MonmielApiModelBundle\Model;

class Quarter
{
    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var integer
     */
    protected $fuel;

    /**
     * @var integer
     */
    protected $charbon;

    /**
     * @var integer
     */
    protected $gaz;

    /**
     * @var integer
     */
    protected $nucleaire;

    /**
     * @var integer
     */
    protected $eolien;

    /**
     * @var integer
     */
    protected $hydraulique;

    /***
     * @var integer
     */
    protected $photovoltaique;

    /***
     * @var integer
     */
    protected $autre;

    /**
     * @var integer
     */
    protected $solde;

    /**
     * @var integer
     */
    protected $consoTotal;


    function __construct($charbon, $date, $eolien, $fuel, $gaz, $hydraulique, $nucleaire, $photovoltaique)
    {
        $this->charbon = $charbon;
        $this->date = $date;
        $this->eolien = $eolien;
        $this->fuel = $fuel;
        $this->gaz = $gaz;
        $this->hydraulique = $hydraulique;
        $this->nucleaire = $nucleaire;
        $this->photovoltaique = $photovoltaique;
        $this->solde = $solde;
    }

    /**
     * @return int
     */
    public function getAutre()
    {
        return $this->autre;
    }

    /**
     * @return int
     */
    public function getCharbon()
    {
        return $this->charbon;
    }

    /**
     * @return int
     */
    public function getConsoTotal()
    {
        return ($this->getFuel() + $this->getEolien() + $this->getCharbon() + $this->getGaz() + $this->getHydraulique() + $this->getNucleaire());
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getEolien()
    {
        return $this->eolien;
    }

    /**
     * @return int
     */
    public function getFuel()
    {
        return $this->fuel;
    }

    /**
     * @return int
     */
    public function getGaz()
    {
        return $this->gaz;
    }

    /**
     * @return int
     */
    public function getHydraulique()
    {
        return $this->hydraulique;
    }

    /**
     * @return int
     */
    public function getNucleaire()
    {
        return $this->nucleaire;
    }

    /**
     * @return int
     */
    public function getPhotovoltaique()
    {
        return $this->photovoltaique;
    }

    /**
     * @return int
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * @param int $autre
     */
    public function setAutre($autre)
    {
        $this->autre = $autre;
    }

    /**
     * @param int $charbon
     */
    public function setCharbon($charbon)
    {
        $this->charbon = $charbon;
    }

    /**
     * @param int $consoTotal
     */
    public function setConsoTotal($consoTotal)
    {
        $this->consoTotal = $consoTotal;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param int $eolien
     */
    public function setEolien($eolien)
    {
        $this->eolien = $eolien;
    }

    /**
     * @param int $fuel
     */
    public function setFuel($fuel)
    {
        $this->fuel = $fuel;
    }

    /**
     * @param int $gaz
     */
    public function setGaz($gaz)
    {
        $this->gaz = $gaz;
    }

    /**
     * @param int $hydraulique
     */
    public function setHydraulique($hydraulique)
    {
        $this->hydraulique = $hydraulique;
    }

    /**
     * @param int $nucleaire
     */
    public function setNucleaire($nucleaire)
    {
        $this->nucleaire = $nucleaire;
    }

    /**
     * @param int $photovoltaique
     */
    public function setPhotovoltaique($photovoltaique)
    {
        $this->photovoltaique = $photovoltaique;
    }

    /**
     * @param int $solde
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;
    }
}
