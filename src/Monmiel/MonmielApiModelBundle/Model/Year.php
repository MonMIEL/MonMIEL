<?php

namespace Monmiel\MonmielApiModelBundle\Model;

/**
 * Modeling of consummation of on Year for the different type of Energy
 */
class Year
{
    /**
     * @var integer
     */
    protected  $yearIdentifiant;

    /**
     * sum consummation for the nucleaire of Year
     * @var float
     */
    protected $consoTotalNucleaire;


    /**
     * sum consummation for the Eolien of Year
     * @var float
     */
    protected $consoTotalEolien;

    /**
     * sum consummation for the hydro of Year
     * @var float
     */
    protected $consoTotalHydraulique;


    /**
     * sum consummation for the pv of Year
     * @var float
     */
    protected $consoTotalPhotovoltaique;

    /**
     * sum consummation for the Central flam of Year
     * @var float
     */
    protected $consoTotalFlamme;


    /**
     * sold of year
     * @var float
     */
    protected $solde;

    function __construct($yearIdentifiant,$consoTotalNucleaire, $consoTotalEolien,$consoTotalPhotovoltaique, $consoTotalFlamme, $consoTotalHydraulique, $solde)
    {
        $this->consoTotalEolien = $consoTotalEolien;
        $this->consoTotalFlamme = $consoTotalFlamme;
        $this->consoTotalHydraulique = $consoTotalHydraulique;
        $this->consoTotalNucleaire = $consoTotalNucleaire;
        $this->consoTotalPhotovoltaique = $consoTotalPhotovoltaique;
        $this->solde = $solde;
        $this->yearIdentifiant = $yearIdentifiant;
    }

    /**
     * @param float $consoTotalEolien
     */
    public function setConsoTotalEolien($consoTotalEolien)
    {
        $this->consoTotalEolien = $consoTotalEolien;
    }

    /**
     * @return float
     */
    public function getConsoTotalEolien()
    {
        return $this->consoTotalEolien;
    }

    /**
     * @param float $consoTotalHydraulique
     */
    public function setConsoTotalHydraulique($consoTotalHydraulique)
    {
        $this->consoTotalHydraulique = $consoTotalHydraulique;
    }

    /**
     * @return float
     */
    public function getConsoTotalHydraulique()
    {
        return $this->consoTotalHydraulique;
    }

    /**
     * @param float $consoTotalPhotovoltaique
     */
    public function setConsoTotalPhotovoltaique($consoTotalPhotovoltaique)
    {
        $this->consoTotalPhotovoltaique = $consoTotalPhotovoltaique;
    }

    /**
     * @return float
     */
    public function getConsoTotalPhotovoltaique()
    {
        return $this->consoTotalPhotovoltaique;
    }

    /**
     * @param float $consoTotalflamme
     */
    public function setConsoTotalFlamme($consoTotalflamme)
    {
        $this->consoTotalFlamme = $consoTotalflamme;
    }

    /**
     * @return float
     */
    public function getConsoTotalFlamme()
    {
        return $this->consoTotalFlamme;
    }

    /**
     * @param float $consoTotalnucleaire
     */
    public function setConsoTotalNucleaire($consoTotalnucleaire)
    {
        $this->consoTotalNucleaire = $consoTotalnucleaire;
    }

    /**
     * @return float
     */
    public function getConsoTotalNucleaire()
    {
        return $this->consoTotalNucleaire;
    }

    /**
     * @param float $solde
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;
    }

    /**
     * @return float
     */
    public function getSolde()
    {
        return $this->solde;
    }
}
