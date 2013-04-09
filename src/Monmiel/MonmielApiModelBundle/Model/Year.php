<?php

namespace Monmiel\MonmielApiModelBundle\Model;

use JMS\Serializer\Annotation as Ser;

/**
 * @Ser\AccessType("public_method")
 * @Ser\XmlRoot("year")
 * @Ser\ExclusionPolicy("none")
 */
class Year
{
    /**
     * @var integer
     * @Ser\Exclude
     */
    protected  $yearIdentifiant;

    /**
     * sum consummation for the nucleaire of Year
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("nuclear")
     */
    protected $consoTotalNucleaire;


    /**
     * sum consummation for the Eolien of Year
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("wind")
     */
    protected $consoTotalEolien;

    /**
     * sum consummation for the hydro of Year
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("hydraulic")
     */
    protected $consoTotalHydraulique;


    /**
     * sum consummation for the pv of Year
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("photovoltaic")
     */
    protected $consoTotalPhotovoltaique;

    /**
     * sum consummation for the Central flam of Year
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("flame")
     */
    protected $consoTotalFlamme;

    /**
     * sum consummation for the Import of Year
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("import")
     */
    protected $consoTotalImport;

    /**
     * sum consummation for the Steps
     * @var float
     * @Ser\Type("double")
     * @Ser\SerializedName("steps")
     */
    protected $consoTotalSteps;

    /**
     * @var float
     * @Ser\Exclude
     */
    protected $consoTotalGlobale;


    /**
     * sold of year
     * @var float
     * @Ser\Exclude
     */
    protected $solde;

    /**
     * Represent sum of interval of quarter, useful is missing value during year
     * @var float
     *
     */
    protected $nbInterval;

    /**
     * @param float $nbInterval
     */
    public function setNbInterval($nbInterval)
    {
        $this->nbInterval = $nbInterval;
    }

    /**
     * @return float
     */
    public function getNbInterval()
    {
        return $this->nbInterval;
    }

    function __construct($yearIdentifiant,$consoTotalNucleaire, $consoTotalEolien,$consoTotalPhotovoltaique, $consoTotalFlamme, $consoTotalHydraulique, $solde, $consoTotalImport = 0, $consoTotalSteps = 0)
    {
        $this->consoTotalEolien = $consoTotalEolien;
        $this->consoTotalFlamme = $consoTotalFlamme;
        $this->consoTotalHydraulique = $consoTotalHydraulique;
        $this->consoTotalNucleaire = $consoTotalNucleaire;
        $this->consoTotalPhotovoltaique = $consoTotalPhotovoltaique;
        $this->consoTotalImport = $consoTotalImport;
        $this->consoTotalSteps = $consoTotalSteps;
        $this->solde = $solde;
        $this->yearIdentifiant = $yearIdentifiant;
        $this->consoTotalGlobale=$consoTotalEolien + $consoTotalFlamme + $consoTotalHydraulique + $consoTotalNucleaire + $consoTotalPhotovoltaique;
        $this->nbInterval=0;
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
     * @param float $consoTotalFlamme
     */
    public function setConsoTotalFlamme($consoTotalFlamme)
    {
        $this->consoTotalFlamme = $consoTotalFlamme;
    }

    /**
     * @return float
     */
    public function getConsoTotalFlamme()
    {
        return $this->consoTotalFlamme;
    }

    /**
     * @param float $consoTotalGlobale
     */
    public function setConsoTotalGlobale($consoTotalGlobale)
    {
        $this->consoTotalGlobale = $consoTotalGlobale;
    }

    /**
     * @return float
     */
    public function getConsoTotalGlobale()
    {
        return $this->consoTotalGlobale;
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
     * @param float $consoTotalImport
     */
    public function setConsoTotalImport($consoTotalImport)
    {
        $this->consoTotalImport = $consoTotalImport;
    }

    /**
     * @return float
     */
    public function getConsoTotalImport()
    {
        return $this->consoTotalImport;
    }

    /**
     * @param float $consoTotalNucleaire
     */
    public function setConsoTotalNucleaire($consoTotalNucleaire)
    {
        $this->consoTotalNucleaire = $consoTotalNucleaire;
    }

    /**
     * @return float
     */
    public function getConsoTotalNucleaire()
    {
        return $this->consoTotalNucleaire;
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
     * @param float $consoTotalSteps
     */
    public function setConsoTotalSteps($consoTotalSteps)
    {
        $this->consoTotalSteps = $consoTotalSteps;
    }

    /**
     * @return float
     */
    public function getConsoTotalSteps()
    {
        return $this->consoTotalSteps;
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

    /**
     * @param int $yearIdentifiant
     */
    public function setYearIdentifiant($yearIdentifiant)
    {
        $this->yearIdentifiant = $yearIdentifiant;
    }

    /**
     * @return int
     */
    public function getYearIdentifiant()
    {
        return $this->yearIdentifiant;
    }


}


