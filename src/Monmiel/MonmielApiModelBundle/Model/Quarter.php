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
    protected $solde;

    /**
     * @var integer
     * @Ser\Type("integer")
     */
    protected $consoTotal;

    /**
     * @var integer
     * @Ser\Type("integer")
     */
    protected $CapaciteProductionEolian;

    /**
     * @var integer
     * @Ser\Type("integer")
     */
    protected $CapaciteProductionPhotovoltaic;

    function __construct($date, $consoTotal, $eolien, $flamme, $hydraulique, $nucleaire, $photovoltaique, $autre, $solde, $CapaciteProductionEolian,$CapaciteProductionPhotovoltaic)
    {
        $this->autre = $autre;
        $this->consoTotal = $consoTotal;
        $this->date = $date;
        $this->eolien = $eolien;
        $this->flamme = $flamme;
        $this->hydraulique = $hydraulique;
        $this->nucleaire = $nucleaire;
        $this->photovoltaique = $photovoltaique;
        $this->solde = $solde;
        $this->CapaciteProductionEolian = $CapaciteProductionEolian;
        $this->CapaciteProductionPhotovoltaic = $CapaciteProductionPhotovoltaic;
    }


    /**
     * Updates values by setting multiplicity coefficient
     * @param $coeff
     */
    public function coeffMultiplication($coeff)
    {

        $this->eolien = $this->eolien*$coeff;
        //   $this->fuel = $fuel;
        // $this->gaz = $gaz;
        $this->hydraulique = $this->hydraulique*$coeff;
        $this->nucleaire = $this->nucleaire*$coeff;
        $this->photovoltaique = $this->photovoltaique*$coeff;

//        $this->updatesAjustValues();
    }

    /**
     * Check if capacity available is below
     * consumption need, and then ajust
     * values for completion variables
     */
//    private function updatesAjustableValues( )
//    {
//        $this->fuel= math_max(0,$this->consoTotal-($this->hydraulique+ $this->nucleaire+$this->photovoltaique+$this->$this->eolien) );
//    }

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
     * @return int
     */
    public function getEolien()
    {
        return $this->eolien;
    }

    /**
     * @param int $flamme
     */
    public function setFlamme($flamme)
    {
        $this->flamme = $flamme;
    }

    /**
     * @return int
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
     * @param int $solde
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;
    }

    /**
     * @return int
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * @param int $solde
     */
    public function setCapactiteProductionEolian($capaciteProduction)
    {
        $this->CapaciteProductionEolian = $capaciteProduction;
    }

    /**
     * @return int
     */
    public function getCapaciteProductionEolian()
    {
        return $this->CapaciteProductionEolian;
    }

    /**
     * @param int $solde
     */
    public function setCapactiteProductionPhotovoltaic($capaciteProduction)
    {
        $this->CapaciteProductionPhotovoltaic = $capaciteProduction;
    }

    /**
     * @return int
     */
    public function getCapaciteProductionPhotovoltaic()
    {
        return $this->CapaciteProductionPhotovoltaic;
    }
}