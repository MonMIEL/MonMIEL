<?php
namespace Monmiel\MonmielApiModelBundle\Model;

class Year
{
    /**
     * @var integer
     */
    protected  $yearIdentifiant;

    /**
     * @var float
     */
    protected $consoTotalflamme;

    /**
     * @var float
     */
    protected $consoTotalnucleaire;


    /**
     * @var float
     */
    protected $consoTotalEolien;

    /**
     * @var float
     */
    protected $consoTotalHydraulique;

    /**
     * @var float
     */
    protected $consoTotalPhotovoltaique;

    /**
     * @var float
     */
    protected $solde;

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
    public function setConsoTotalflamme($consoTotalflamme)
    {
        $this->consoTotalflamme = $consoTotalflamme;
    }

    /**
     * @return float
     */
    public function getConsoTotalflamme()
    {
        return $this->consoTotalflamme;
    }

    /**
     * @param float $consoTotalnucleaire
     */
    public function setConsoTotalnucleaire($consoTotalnucleaire)
    {
        $this->consoTotalnucleaire = $consoTotalnucleaire;
    }

    /**
     * @return float
     */
    public function getConsoTotalnucleaire()
    {
        return $this->consoTotalnucleaire;
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
