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

    function __construct($yearIdentifiant,$consoTotalNucleaire, $consoTotalEolien,$consoTotalPhotovoltaique, $consoTotalFlamme, $consoTotalHydraulique, $solde)
    {
        $this->consoTotalEolien = $consoTotalEolien;
        $this->consoTotalFlamme = $consoTotalFlamme;
        $this->consoTotalHydraulique = $consoTotalHydraulique;
        $this->consoTotalNucleaire = $consoTotalNucleaire;
        $this->consoTotalPhotovoltaique = $consoTotalPhotovoltaique;
        $this->solde = $solde;
        $this->yearIdentifiant = $yearIdentifiant;
        $this->consoTotalGlobale=$consoTotalEolien + $consoTotalFlamme + $consoTotalHydraulique + $consoTotalNucleaire + $consoTotalPhotovoltaique;
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
     * @param float $consoTotalGlobale
     */
    public function setConsoTotalGlobale($consoTotalGlobale)
    {
        $this->consoTotalGlobale = $consoTotalGlobale;
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

    /**
     * @return float
     */
    public function getConsoTotalGlobale()
    {
        return $this->consoTotalGlobale;
    }

    public function toString ()
    {
        $result="";

        $result=$result . "Nuclear: " .$this->consoTotalNucleaire/1000000 . " TW \n";
        $result=$result . "Eolian: " .$this->consoTotalEolien/1000000 . " TW \n";
        $result=$result . "Hydraulic: " .$this->consoTotalHydraulique/1000000 . " TW \n";
        $result=$result . "Photovoltaic: " .$this->consoTotalPhotovoltaique/1000000 . " TW \n";
        $result=$result . "Thermal: " .$this->consoTotalFlamme/1000000 . " TW \n";
        $result=$result . "Global: " .$this->consoTotalGlobale/1000000 . " TW \n";


        return $result;

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


